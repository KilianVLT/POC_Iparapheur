<?php

namespace App\Tools;

class GraphQLQueryMaker{

    function makeGraphQLQuery($ref): string
    {
        return <<<GQL
            query {
                documentEvents
                (
                    filter: {
                        kind : {equals : DOSSIER_FINANCEMENT }
                        referenceAdministrative : { startsWith : "$ref"}
                    }
                )
                {
                    totalCount
                    pageInfo {
                        hasNextPage
                        hasPreviousPage
                    }
                    edges {
                        node {
                            id
                            nature
                            fonction
                            objectId
                            pieceReference
                            referenceAdministrative
                            fileName
                            kind
                            eventDate
                            file
                            author
                            metadata
                            objectId
                        }
                    }
                }
            }
            GQL;
    }

}
?>