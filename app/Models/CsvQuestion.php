<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CsvQuestion
{

    private string $question;
    private string $answare;
    private array $tags;

    function __construct(array $csvData)
    {
        if (count($csvData) === 3) {
            $this->setQuestion($csvData[0]);
            $this->setAnsware($csvData[1]);
            $this->setTags($csvData[2]);
        }
    }

    public function build()
    {
        return [
            "question" => $this->getQuestion(),
            "answare" => $this->getAnsware(),
            "tags" => $this->getTags(),
        ];
    }

    /**
     * Get the value of question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set the value of question
     *
     * @return  self
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get the value of answare
     */
    public function getAnsware()
    {
        return $this->answare;
    }

    /**
     * Set the value of answare
     *
     * @return  self
     */
    public function setAnsware($answare)
    {
        $this->answare = $answare;

        return $this;
    }

    /**
     * Get the value of tags
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * Set the value of tags
     *
     * @return  self
     */
    public function setTags($tags)
    {

        $this->tags = explode('/', $tags);

        return $this;
    }
}
