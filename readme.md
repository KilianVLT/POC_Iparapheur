# Documentation du projet

## Faire une requête GraphQL pour le Kiosque GED

Dans le fichier Tools/GraphQlQueryMaker.php, vous retrouverez la stucture d'une requête pour le Kiosque GED

## Générer un fichier XML pour le Iparapheur    

Dans le fichier Tools/XMLFileGenerator.php, data doit être de ce format :

        $data = [
            'folder' => [
                'i_Parapheur_reserved_type' => 'value',
                'i_Parapheur_reserved_subtype' => 'value',
                'i_Parapheur_reserved_ext_sig_firstname' => 'value',
                'i_Parapheur_reserved_ext_sig_lastname' => 'value',
                'i_Parapheur_reserved_ext_sig_mail' => 'value',
                'i_Parapheur_reserved_ext_sig_phone' => 'value'
            ],
            'folderName' => 'value',
            'file' => [
                'i_Parapheur_reserved_mainDocument' => 'value',
            ],
            'fileName' => 'value'
        ]

Les fichiers sont stockés dans /var/tmp/xml, l'emplacement est modifiable dans services.yaml