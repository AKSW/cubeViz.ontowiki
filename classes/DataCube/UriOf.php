<?php
/**
 * This class provides neccessary URI's
 *
 * @copyright Copyright (c) 2011, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @category OntoWiki
 * @package Extensions
 * @subpackage Cubeviz
 * @author Ivan Ermilov 
 */
class DataCube_UriOf
{    
    //special entities
	const Qb = "http://purl.org/linked-data/cube#";
	const RdfType = "http://www.w3.org/1999/02/22-rdf-syntax-ns#type";
	const RdfsLabel = "http://www.w3.org/2000/01/rdf-schema#label";
	
	//cube concepts
	const DataStructureDefinition = "http://purl.org/linked-data/cube#DataStructureDefinition";
	const ComponentSpecification = "http://purl.org/linked-data/cube#ComponentSpecification";
	const ComponentProperty = "http://purl.org/linked-data/cube#ComponentProperty";
	const DimensionProperty = "http://purl.org/linked-data/cube#DimensionProperty";
	const MeasureProperty = "http://purl.org/linked-data/cube#MeasureProperty";
	const AttributeProperty = "http://purl.org/linked-data/cube#AttributeProperty";
	const DataSet = "http://purl.org/linked-data/cube#DataSet";
	const Observation = "http://purl.org/linked-data/cube#Observation";

	//cube properties
	const Component = "http://purl.org/linked-data/cube#component";
	const Measure = "http://purl.org/linked-data/cube#measure";
	const Dimension = "http://purl.org/linked-data/cube#dimension";
	const Attribute = "http://purl.org/linked-data/cube#attribute";
	const Order = "http://purl.org/linked-data/cube#order";
	const Datasetrel = "http://purl.org/linked-data/cube#dataset";
	const Structure = "http://purl.org/linked-data/cube#structure";
}