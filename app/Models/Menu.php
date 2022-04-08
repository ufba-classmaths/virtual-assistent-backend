<?php

namespace App\Models;

class Menu
{
    public string $tag;
    public array $questions;
    public array $submenu;

    function __construct($tag)
    {
        $this->setTag($tag);
        $this->questions = [];
        $this->submenu = [];
    }


    public function build()
    {
        return [
            "tag" => $this->getTag(),
            "submenu" => $this->getSubmenu(),
            "questions" => $this->getQuestions(),
        ];
    }
    /**
     * Get the value of submenu
     *
     * @return  array
     */
    public function getSubmenu()
    {
        $removedMenu = null;
        if (count($this->submenu) > 1) {
            $removedMenu = $this->submenu[0];

            $this->submenu = array_splice($this->submenu, 1);
        }
        if (count($this->submenu) == 0 && $removedMenu) {
            return $removedMenu->build();
        }
        return $this->getSubmenu($this->submenu);
    }

    /**
     * Set the value of submenu
     *
     * @param  array  $submenu
     *
     * @return  self
     */
    public function setSubmenu($submenu)
    {
        array_push($this->submenu, $submenu);

        return $this;
    }

    /**
     * Get the value of questions
     *
     * @return array
     */
    public function getQuestions()
    {
        return json_encode($this->questions);
    }

    /**
     * Set the value of questions
     *
     * @param array $questions
     *
     * @return self
     */
    public function setQuestions(array $questions): self
    {
        $this->questions = $questions;

        return $this;
    }

    /**
     * Get the value of tag
     *
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * Set the value of tag
     *
     * @param string $tag
     *
     * @return self
     */
    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }
}
