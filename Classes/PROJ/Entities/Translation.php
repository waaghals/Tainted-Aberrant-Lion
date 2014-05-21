<?php

namespace PROJ\Entities;

/**
 * @Entity 
 */
class Translation {

    /**
     *  @id @Column(type="integer")
     */
    private $sentenceId;

    /**
     * @id @Column(type="string")
     */
    private $language;

    /**
     * @Column(type="string")
     */
    private $translation;

    public function getSentenceId() {
        return $this->sentenceId;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function getTranslation() {
        return $this->translation;
    }

    public function setSentenceId($sentenceId) {
        $this->sentenceId = $sentenceId;
    }

    public function setLanguage($language) {
        $this->language = $language;
    }

    public function setTranslation($translation) {
        $this->translation = $translation;
    }

}
