<?php
namespace App\Manager;

use App\Form\CommentType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Ramsey\Uuid\Uuid;
use App\Entity\CommentFile;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;

class CommentManager
{
    private $formFactory;
    
    private $manager;
    
    private $tokenStorage;
    
    private $uploadDir;
    
    public function __construct(
        FormFactoryInterface $formFactory,
        ObjectManager $manager,
        TokenStorageInterface $tokenStorage,
        string $uploadDir
    ) {
        $this->formFactory = $formFactory;
        $this->manager = $manager;
        $this->tokenStorage = $tokenStorage;
        $this->uploadDir = $uploadDir;
    }
    
    public function processForm($comment, Product $product)
    {
        $tmpCommentFile = [];
        
        foreach ($comment->getFiles() as $fileArray) {
            foreach ($fileArray as $file) {
                $name = sprintf(
                    '%s.%s',
                    Uuid::uuid1(),
                    $file->getClientOriginalExtension()
                );
                
                $commentFile = new CommentFile();
                $commentFile->setComment($comment)
                    ->setMimeType($file->getMimeType())
                    ->setName($file->getClientOriginalName())
                    ->setFileUrl($this->uploadDir . $name);
                
                $tmpCommentFile[] = $commentFile;
                
                $file->move(
                    __DIR__.'/../../public'.$this->uploadDir,
                    $name
                );
                
                $this->manager->persist($commentFile);
            }
        }
        
        $token = $this->tokenStorage->getToken();
        if (!$token){
            throw new \Exception();
        }
        $user = $token->getUser();
        if (!$user){
            throw new \Exception();
        }
        
        $comment->setFiles($tmpCommentFile)
            ->setAuthor($user)
            ->setProduct($product);
        
        $this->manager->persist($comment);
        $this->manager->flush();
    }
    
    public function handleRequest(FormInterface $form, Request $request)
    {
        $form->handleRequest($request);
    }
    
    public function getBaseForm($comment)
    {
        return $this->formFactory->create(
            CommentType::class,
            $comment,
            ['stateless' => true]
        );
    }
}

