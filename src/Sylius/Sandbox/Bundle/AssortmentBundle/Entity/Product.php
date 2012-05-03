<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\AssortmentBundle\Entity;

use Sylius\Bundle\CategorizerBundle\Model\CategoryInterface;
use Sylius\Bundle\AssortmentBundle\Entity\CustomizableProduct as BaseProduct;
use Symfony\Component\Validator\Constraints as Assert;

class Product extends BaseProduct
{
    /**
     * Product category.
     *
     * @Assert\NotBlank
     *
     * @var CategoryInterface
     */
    protected $category;

    protected $imagePath;
    public $image;

    /**
     * Get category.
     *
     * @return CategoryInterface
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category.
     *
     * @param CategoryInterface $category
     */
    public function setCategory(CategoryInterface $category)
    {
        $this->category = $category;
    }

    /**
     * This is a proxy method to access master variant price.
     * Because if there are no options/variants defined, the master variant is
     * the project.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->masterVariant->getPrice();
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public function getAbsoluteImagePath()
    {
        return null === $this->getImagePath() ? null : $this->getImageUploadRootDir().'/'.$this->getImagePath();
    }

    public function getImageWebPath()
    {
        return null === $this->getImagePath() ? null : $this->getImageUploadDir().'/'.$this->getImagePath();
    }

    public function getImageUploadDir()
    {
        return 'uploads/images';
    }

    public function hasImage()
    {
        return null !== $this->getImagePath();
    }

    public function saveImage()
    {
        if (null === $this->image) {

            return;
        }

        $this->setImagePath(uniqid().'.'.$this->image->guessExtension());
        $this->image->move($this->getImageUploadRootDir(), $this->getImagePath());
    }

    public function deleteImage()
    {
        if ($file = $this->getAbsoluteImagePath()) {
            unlink($file);
        }
    }

    protected function getImageUploadRootDir()
    {
        return __DIR__.'/../../../../../../public/'.$this->getImageUploadDir();
    }
}
