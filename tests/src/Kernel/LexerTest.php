<?php

namespace Drupal\Tests\simple_lexer\Kernel;
use Drupal\KernelTests\KernelTestBase;

/**
 * Unitary test for the Lexer service.
 *
 * @group simple_lexer
 */
class LexerTest extends KernelTestBase  {

  /**
   * The lexer service.
   *
   * @var \Drupal\simple_lexer\Lexer
   */
  protected $lexer;

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['system', 'simple_lexer'];

  protected function setUp() {
    parent::setUp();
    $this->lexer = \Drupal::service('simple_lexer.lexer');
  }

  /**
   * @param $inputs
   * @param $expected_results
   *
   * @dataProvider lexerProvider
   */
  public function testLexer($inputs, $expected_results){
    $results = [];
    foreach ($inputs as $input) {
      $results[] = $this->lexer->operate($input);
    }
    $this->assertEquals($expected_results, $results);
  }

  public function lexerProvider() {
    return [
      [
        ['8+4-2', '2-1+3', '2+2', '2-1', '-2+1'],
        [10, 4, 4, 1, -1],
      ],
    ];
  }

}
