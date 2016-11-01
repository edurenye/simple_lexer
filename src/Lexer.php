<?php

namespace Drupal\simple_lexer;

/**
 * This Service offers lexer that calculates simple operations in a string.
 * The supported operations are '+' and '-'.
 */
class Lexer {

  /**
   * Evaluates a string representing a mathematical function.
   *
   * @param $input
   *   The string we want to evaluate. It must represent a mathematical function
   *   containing just the minus and plus operations.
   *   Example: '-2+8-1'
   *
   * @return int
   *   Returns the result of evaluating the operations of the string.
   */
  public function operate($input) {
    $matches = [];
    if (preg_match_all('/(?P<number>\d+)|(?P<operator>[\+|\-])/', $input, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE) === FALSE) {
      // There was a failure when evaluating the regular expression.
      throw new \LogicException();
    };

    $result = 0;
    $last_operator = '+';
    foreach ($matches as $match) {
      if (isset($match['operator'])) {
        $last_operator = $match['operator'][0];
      }
      elseif (isset($match['number'])) {
        switch ($last_operator) {
          case '+':
            $result = $result + $match['number'][0];
            break;

          case '-':
            $result = $result - $match['number'][0];
            break;
        }
        $last_operator = NULL;
      }
    }
    return $result;
  }

}
