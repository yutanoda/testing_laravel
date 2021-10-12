<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Exception;
use Tests\TestCase;


class LikesTest extends TestCase 
{

  use DatabaseTransactions;

  protected $post;

  public function setUp(): void
  {
    parent::setUp();

   // $this->post = Post::factory()->create();
    $this->post = createPost();

    $this->signIn();

  }

  /** @test */
  public function a_user_can_like_a_model()
  {

    $this->post->like();
    

    $this->assertDatabaseHas('likes', [
      'user_id' => $this->user->id,
      'likeable_id' => $this->post->id,
      'likeable_type' => get_class($this->post)
    ]);

    $this->assertTrue($this->post->isLiked());


  }

  /** @test */
  public function a_user_can_like_a_post()
  {


    $this->post->like();

    $this->assertDatabaseHas('likes', [
      'user_id' => $this->user->id,
      'likeable_id' => $this->post->id,
      'likeable_type' => get_class($this->post)
    ]);

    $this->assertTrue($this->post->isLiked());
  }

  /** @test */
  public function a_user_can_unlike_a_post()
  {


    $this->post->like();
    $this->post->unlike();

    $this->assertDatabaseMissing('likes', [
      'user_id' => $this->user->id,
      'likeable_id' => $this->post->id,
      'likeable_type' => get_class($this->post)
    ]);

    $this->assertFalse($this->post->isLiked());
  }
  
  /** @test */
  public function a_user_may_toggle_a_posts_like_status()
  {

    $this->post->toggle();

    $this->assertTrue($this->post->isLiked());

    $this->post->toggle();

    $this->assertFalse($this->post->isLiked());

  }

  /** @test */

  public function a_post_knows_how_many_likes_it_has()
  {


    $this->post->toggle();

    $this->assertEquals(1, $this->post->likesCount);

  }

  public function getLikesCountAttribute()
  {
    return $this->likes()->count();
  }


}