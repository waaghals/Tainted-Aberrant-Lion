<?php

namespace PROJ\Entities;

/**
 * @Entity 
 */
class Translation {

    /**
     *  @id @unique @Column(type="String")
     */
    private $sentenceKey;

    /**
     * @id @Column(type="string")
     */
    private $language;

    /**
     * @Column(type="string")
     */
    private $translation;

    public function getSentenceKey() {
        return $this->sentenceKey;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function getTranslation() {
        return $this->translation;
    }

    public function setSentenceKey($sentenceKey) {
        $this->sentenceKey = $sentenceKey;
    }

    public function setLanguage($language) {
        $this->language = $language;
    }

    public function setTranslation($translation) {
        $this->translation = $translation;
    }

}
