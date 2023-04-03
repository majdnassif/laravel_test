<?php

namespace App\Service;

use App\Events\PostCreatedEvent;
use App\Exceptions\CustomExceptions\CreatePostException;
use App\Models\Post\Post;
use App\Repository\Post\PostRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    private array $relationships = ['user'];
    public function __construct(private PostRepository $postRepository,private ImageService $imageService)
    {
    }


    public function create(int $user_id, string $content ,?array $images = []) :mixed
    {
        try {
            $post =  $this->postRepository->create(['user_id'=>$user_id,'content'=>$content]);

            if($post)
               PostCreatedEvent::dispatch($post);
        }
        catch (CreatePostException $e)
        {
            return $e->getMessage();
        }

        if($images)
           $this->storePostImages($post,$images);

        return $post;
    }

    private function storePostImages(Post $post,array $images):void
    {
        foreach ($images as $image)
        {
            $url = $image->store('image');
            $this->imageService->create(Post::class,$post['id'],$url);
        }
    }


    public function show(string $postId):?Model
    {
        return $this->postRepository->find($postId,$this->relationships);
    }


    public function isPostExist(int $postId):bool
    {
        return $this->postRepository->findById($postId) ? true : false;
    }

    public function allPosts():LengthAwarePaginator
    {
        return $this->postRepository->all($this->relationships);
    }


    public function updatePost(int $postId, array $data, ?UploadedFile $images = null):?bool
    {
        if(!$this->isPostExist($postId))
            return null;

        $post = $this->postRepository->findById($postId);

        if($images)
            $this->storePostImages($post,$images);


        $payloadData = $this->getPayloadData($data);
        return $this->postRepository->update($post, $payloadData);

    }

    public function getPayloadData(array $data): ?array
    {
        $newPostInfo = [];

        if($data['content'])
            $newPostInfo['content']  = $data['content'];

        return $newPostInfo;
    }


}
