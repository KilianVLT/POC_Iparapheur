<?php

namespace App\Tools;

class XMLFileGenerator{

    public function __construct(private string $tempDir) {}

    public function saveTempFile(string $content): string
    {
        if (!is_dir($this->tempDir)) {
            mkdir($this->tempDir, 0775, true);
        }
        
        $filename = $this->tempDir . '/iparapheur_' . uniqid() . '.xml';
        file_put_contents($filename, $content);

        return $filename;
    }


    public function generateXMLFile(array $data): string
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        // Création de l'élément racine <premis> avec ses namespaces
        $premis = $dom->createElementNS('http://www.loc.gov/premis/v3', 'premis');
        $dom->appendChild($this->addPremis($premis));

        // Partie Folder
        $folderObject = $dom->createElement('object');
        $folderObject->setAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'xsi:type', 'intellectualEntity');
        $folderObject = $this->addSigProps($data['folder'], $folderObject);
        $folderObject->appendChild($dom->createElement('originalName', $data['folderName']));
        $premis->appendChild($folderObject);

        // Partie File
        $fileObject = $dom->createElement('object');
        $fileObject->setAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'xsi:type', 'file');
        $fileObject = $this->addSigProps($data['file'], $fileObject);
        $fileObject->appendChild($dom->createElement('originalName', $data['fileName']));
        $premis->appendChild($fileObject);

        return $this->saveTempFile($dom->saveXML());
    }


    private function addPremis($premis){
        $premis->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $premis->setAttribute('version', '3.0');
        $premis->setAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'xsi:schemaLocation', 'http://www.loc.gov/premis/v3 http://www.loc.gov/standards/premis/v3/premis.xsd');
        return $premis;
    }


    private function addSigProps(array $data, \DOMElement $parent){
        $dom = $parent->ownerDocument;

        foreach ($data as $type => $value) {
            $sigProp = $dom->createElement('significantProperties');
            
            $propType = $dom->createElement('significantPropertiesType', $type);
            $propValue = $dom->createElement('significantPropertiesValue', $value);
            
            $sigProp->appendChild($propType);
            $sigProp->appendChild($propValue);
            $parent->appendChild($sigProp);
        }

        return $parent;
    }
}

?>

