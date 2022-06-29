<?php

class Node 
{

    protected int $value;
    protected ?Node $left;
    protected ?Node $right;

    public function __construct(int $value) {
        $this->value = $value;
        $this->left = NULL;
        $this->right = NULL;
    }

    public function left(?Node $left = NULL): ? Node {
        if (!empty($left)) {
            $this->left = $left;
        }

        return $this->left;
    }

    public function right(?Node $right = NULL): ? Node {
        if (!empty($right)) {
            $this->right = $right;
        }

        return $this->right;
    }

    public function value(?int $value = NULL): ? int {
        if (!empty($value)) {
            $this->value = $value;
        }

        return $this->value;
    }


    public function deep(): int {
        $left = empty($this->left()) ? 0 : $this->left()->deep();
        $right = empty($this->right()) ? 0 : $this->right()->deep();

        return 1 + max($left, $right);
    }

    public function preOrder(): array {
        $values = [$this->value];

        if (!empty($this->left)) {
            $values = array_merge($values, $this->left()->preOrder()); 
        }

        if (!empty($this->right)) {
            $values = array_merge($values, $this->right()->preOrder()); 
        }

        return $values;
    }

    protected function hasChilds(): bool {
        if (!empty($this->left) || !empty($this->right)) {
            return true;
        }
        return false;
    }

    public function invert(): Node {

        $invert = new self($this->value);

        $invert->left($this->right()->hasChilds() ? $this->right()->invert() : $this->right);
        $invert->right($this->left()->hasChilds() ? $this->left()->invert() : $this->left);

        return $invert;
    }

}

$tree = new Node(1);
$tree->left(new Node(2));
$tree->right(new Node(3));
$tree->left()->left(new Node(4));
$tree->left()->right(new Node(5));
$tree->right()->left(new Node(6));
$tree->right()->right(new Node(7));
$tree->left()->left()->left(new Node(8));
$tree->left()->left()->right(new Node(9));

print_r($tree->preOrder());
print_r($tree->invert()->preOrder());

