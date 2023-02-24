<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;
use Vich\UploaderBundle\Entity\File as EntityFile;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
#[Vich\Uploadable]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type:'string', length: 80)]
    private $name = null;


    #[ORM\Column(type: 'text', nullable: true)]
    private $description = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private $picture;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private $category = null;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: Opinion::class)]
    private $opinion;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updated_at;

    #[ORM\ManyToOne(targetEntity: Matter::class ,inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private $matter = null;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'picture')]
    #[Assert\Image(mimeTypesMessage: 'Ceci n\'est pas une image')]
    #[Assert\File(
        maxSize: '1M', 
        maxSizeMessage: 'Cette image ne doit pas dépasser les {{ limit }} {{ suffix }}'
    )]
    private $profileFile;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $size = null;

    

    public function __construct()
    {
        $this->Opinion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCategory(): ?category
    {
        return $this->category;
    }

    public function setCategory(?category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, opinion>
     */
    public function getOpinion(): Collection
    {
        return $this->opinion;
    }

    public function addOpinion(Opinion $opinion): self
    {
        if (!$this->opinion->contains($opinion)) {
            $this->opinion->add($opinion);
            $opinion->setProducts($this);
        }

        return $this;
    }

    public function removeOpinion(Opinion $opinion): self
    {
        if ($this->opinion->removeElement($opinion)) {
            // set the owning side to null (unless already changed)
            if ($opinion->getProducts() === $this) {
                $opinion->setProducts(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getMatter(): ?Matter
    {
        return $this->matter;
    }

    public function setMatter(?Matter $matter): self
    {
        $this->matter = $matter;

        return $this;
    }

    public function getProfileFile(): ?File
    {
        return $this->profileFile;
    }

    public function setProfileFile(?File $profileFile = null): self
    {
        $this->profileFile = $profileFile;

        if ($profileFile !== null) {
            $this->updated_at = new DateTimeImmutable();
        }

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;

        return $this;
    }

    
}
