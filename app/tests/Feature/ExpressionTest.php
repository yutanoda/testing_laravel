<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;



class ExpressionTest extends TestCase 
{

  use DatabaseTransactions;

  /** @test */
  public function it_finds_a_string()
  {
    $regex = Expression::make()->find('www');
    $this->assertTrue($regex->test('www'));

    $regex = Expression::make()->then('www');
    $this->assertTrue($regex->test('www'));

  }

  /** @test */
  public function it_checks_for_anything()
  {
    $regex = Expression::make()->anything();

    $this->assertTrue($regex->test('foo'));
  }

  /** @test */
  public function it_maybe_has_a_value()
  {
    $regex = Expression::make()->maybe('http');

    $this->assertTrue($regex->test('http'));
    $this->assertTrue($regex->test(''));
  }

  /** @test */
  public function it_can_chain_method_calls()
  {
    $regex = Expression::make()->find('www')->maybe('.')->then('laracasts');

    $this->assertTrue($regex->test('www.laracasts'));
    $this->assertFalse($regex->test('wwwXlaracasts'));

  }

  /** @test */
  public function it_can_exclude_values()
  {
    $regex = Expression::make()
      ->find('foo')
      ->anythingBut('bar')
      ->then('biz');

      $this->assertTrue($regex->test('foobazbiz'));
      $this->assertFalse($regex->test('foobarbiz'));

  }

}