<?php
/**
 * This class represents an LinkHandle object
 * Used for handling files in the links/ directory
 *
 * @copyright Copyright (c) 2011, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @category OntoWiki
 * @package Extensions
 * @subpackage Cubeviv
 * @author Konrad Abicht
 */ 
class CubeViz_ViewHelper
{
    public static $isCubeVizAppLoaded = false;
    public static $isCubeVizModuleLoaded = false;
    public static $isCubeVizIndexLoaded = false;
    
    /**
     * Get information about the selected model
     * @param $modelStore Store of selected model
     * @param $model Model itself
     * @param $modelIri Iri of the selected model
     * @return Array Array with fields about dc:creator, dc:description, 
     *               rdfs:label, doap:license, doap:revision, doap:shortdesc
     */
    public static function getModelInformation ($modelStore, $model, $modelIri) 
    {
        $modelResource = new OntoWiki_Model_Resource($modelStore, $model, $modelIri);
        $modelResource = $modelResource->getValues();
        
        $usedPredicates = array(
            'dc:creator', 'dc:description', 'rdfs:label', 'doap:license',
            'doap:revision', 'doap:shortdesc'
        );
        
        // CubeViz_Array is a simple implementation of ArrayAccess interface
        // It allows you to set a default which is used if the value you want
        // to access is not set
        $modelInformation = new CubeViz_Array('');
        $modelInformation['uri'] = $modelIri;
        
        // if model resource contains further information about the model
        if(true === isset($modelResource [$modelIri])
           && is_array($modelResource [$modelIri])) {
               
            // Build array modelInformation which contains exactly the predicates from
            // $usedPredicates as keys and the content as value.
            foreach ($modelResource [$modelIri] as $predicateUri => $ele) {
                $compactPredicateUri = OntoWiki_Utils::compactUri($predicateUri);
                if(true == in_array($compactPredicateUri, $usedPredicates)) {
                    $modelInformation [$compactPredicateUri] = 
                        $modelResource [$modelIri][$predicateUri][0]['content'];
                }
                if(false === isset($modelInformation [$compactPredicateUri])){
                    $modelInformation [$compactPredicateUri] = '';
                }
            }
        }
        
        // if no title was set, use title helper
        if(false === isset($modelInformation['rdfs:label'])
           || '' == $modelInformation['rdfs:label']) {
            $th = new OntoWiki_Model_TitleHelper($model);
            $th->addResource($modelIri);
            $modelInformation['rdfs:label'] = $th->getTitle($modelIri);
        }
        
        return $modelInformation;
    }
    
    /**
     * 
     */
    public static function initApp(&$view, &$model, $backend, $cacheDir, 
        $modelInformation, $context, $modelIri, $staticUrlBase, $baseImagesPath, 
        $dataHash, $uiHash) 
    {
        // if cubeVizApp was not loaded yet
        if(false === CubeViz_ViewHelper::$isCubeVizAppLoaded) {               
            
            /**
             * Set view and some of its properties.
             */
            $view->cubevizImagesPath = $baseImagesPath;
            
            /**
             * Get hashes from parameter list
             */
            // hash for data
            if(null == $dataHash) {
                $dataHash = CubeViz_ConfigurationLink::$filePrefForDataHash;
            }
            
            // hash for ui
            if(null == $uiHash) {
                $uiHash = CubeViz_ConfigurationLink::$filePrefForUiHash;
            }
                
            $view->isCubeVizModuleLoaded = false === isset($view->isCubeVizModuleLoaded)
                ? false : $view->isCubeVizModuleLoaded;
            
            /**
             * Read information from files according to given hashes
             */
            $c = new CubeViz_ConfigurationLink($cacheDir);
            $config = array();
            
            $config['data'] = $c->read ($dataHash, $model);
            $newDataHash = CubeViz_ConfigurationLink::$filePrefForDataHash
                . md5(json_encode($config['data']));
            
            $config['ui'] = $c->read ($uiHash, $model);
            $newUiHash = CubeViz_ConfigurationLink::$filePrefForUiHash
                . md5(json_encode($config['ui']));

            $config['backend'] = array(
                'context'               => $context, 
                'database'              => $backend,
                'dataHash'              => $newDataHash,
                'imagesPath'            => $baseImagesPath,
                'modelUrl'              => $modelIri,
                'uiHash'                => $newUiHash,
                'uiParts'               => array(
                    'module'            => array('isLoaded'=> CubeViz_ViewHelper::$isCubeVizModuleLoaded),
                    'index'             => array('isLoaded'=> CubeViz_ViewHelper::$isCubeVizIndexLoaded)
                ),
                'retrievedObservations' => array(),
                'sparqlEndpoint'        => 'local',
                'url'                   => $staticUrlBase . 'cubeviz/'
            );
            
            // load observations related to given data
            $query = new DataCube_Query($model);
            
            $config['backend']['retrievedObservations'] = $query->getObservations(array(
                'selectedComponents' => $config['data']['selectedComponents'],
                'selectedDS' => array('url' => $config['data']['selectedDS']['url'])
            ));
                
            CubeViz_ViewHelper::$isCubeVizAppLoaded = true;
            
            return $config;
        }
        
        return null;
    }
}
