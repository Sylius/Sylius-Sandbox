# Run apt-get update to create the stamp file
execute "apt-get-update" do
  command "apt-get update"
  ignore_failure true
  not_if do ::File.exists?('/var/lib/apt/periodic/update-success-stamp') end
end

# For other recipes to call to force an update
execute "apt-get update" do
  command "apt-get update"
  ignore_failure true
  action :nothing
end

# provides /var/lib/apt/periodic/update-success-stamp on apt-get update
package "update-notifier-common" do
  notifies :run, resources(:execute => "apt-get-update"), :immediately
end

execute "apt-get-update-periodic" do
  command "apt-get update"
  ignore_failure true
  only_if do
    File.exists?('/var/lib/apt/periodic/update-success-stamp') &&
    File.mtime('/var/lib/apt/periodic/update-success-stamp') < Time.now - 86400
  end
end

# install the software we need
%w(
mysql-server
curl
apache2
libapache2-mod-php5
git
php5-cli
php5-curl
php5-sqlite
php5-intl
php-apc
php5-mysql
).each { | pkg | package pkg }

template "/etc/apache2/sites-enabled/vhost.conf" do
  user "root"
  mode "0644"
  source "vhost.conf.erb"
  notifies :reload, "service[apache2]"
end

service "apache2" do
  supports :restart => true, :reload => true, :status => true
  action [ :enable, :start ]
end

execute "check if short_open_tag is Off in /etc/php5/apache2/php.ini?" do
  user "root"
  not_if "grep 'short_open_tag = Off' /etc/php5/apache2/php.ini"
  command "sed -i 's/short_open_tag = On/short_open_tag = Off/g' /etc/php5/apache2/php.ini"
end

execute "check if short_open_tag is Off in /etc/php5/cli/php.ini?" do
  user "root"
  not_if "grep 'short_open_tag = Off' /etc/php5/cli/php.ini"
  command "sed -i 's/short_open_tag = On/short_open_tag = Off/g' /etc/php5/cli/php.ini"
end

execute "check if date.timezone is Europe/Paris in /etc/php5/apache2/php.ini?" do
  user "root"
  not_if "grep '^date.timezone = Europe/Paris' /etc/php5/apache2/php.ini"
  command "sed -i 's/;date.timezone =.*/date.timezone = Europe\\/Paris/g' /etc/php5/apache2/php.ini"
end

execute "check if date.timezone is Europe/Paris in /etc/php5/cli/php.ini?" do
  user "root"
  not_if "grep '^date.timezone = Europe/Paris' /etc/php5/cli/php.ini"
  command "sed -i 's/;date.timezone =.*/date.timezone = Europe\\/Paris/g' /etc/php5/cli/php.ini"
end

execute "preparing parameters.yml file" do
  command "cp /mnt/sylius/sandbox/config/container/parameters.yml.dist /mnt/sylius/sandbox/config/container/parameters.yml"
end

execute "doctrine:database:drop" do
  command "/mnt/sylius/sandbox/console doctrine:database:drop --force"
end

execute "doctrine:database:create" do
  command "/mnt/sylius/sandbox/console doctrine:database:create"
end

execute "doctrine:schema:create" do
  command "/mnt/sylius/sandbox/console doctrine:schema:create --em=default"
end

execute "doctrine:fixtures:load" do
  command "/mnt/sylius/sandbox/console doctrine:fixtures:load"
end

execute "assetic:dump" do
  command "/mnt/sylius/sandbox/console assetic:dump"
end

bash "Running composer install and preparing the Sylius repository" do
  not_if "test -e /vagrant/vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/public"
  user "vagrant"
  cwd "/mnt/sylius"
  code <<-EOH
    set -e
    ln -sf /var/tmp/vendor
    curl -s https://getcomposer.org/installer | php
    COMPOSER_VENDOR_DIR="/var/tmp/vendor" php composer.phar install
  EOH
end