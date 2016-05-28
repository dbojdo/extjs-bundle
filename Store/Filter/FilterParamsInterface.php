<?php
namespace Webit\Bundle\ExtJsBundle\Store\Filter;

/**
 *
 * @author dbojdo
 *
 */
interface FilterParamsInterface
{
    const LIKE_WILDCARD_RIGHT = 'right';
    const LIKE_WILDCARD_LEFT = 'left';
    const LIKE_WILDCARD_BOTH = 'both';
    const LIKE_WILDCARD_NONE = 'none';

    public function getCaseSensitive();

    public function getLikeWildcard();

    public function getNegation();

    public function setCaseSensitive($caseSensitive);

    public function setLikeWildcard($likeWildcard);

    public function setNegation($negation);
}
