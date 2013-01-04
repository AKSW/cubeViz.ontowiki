/// <reference path="..\..\..\declaration\libraries\jquery.d.ts" />
/// <reference path="..\..\..\declaration\libraries\Underscore.d.ts" />

class View_IndexAction_VisualizationSelector extends CubeViz_View_Abstract
{
    /**
     * 
     */
    constructor(attachedTo:string, app:CubeViz_View_Application) 
    {
        super("View_IndexAction_VisualizationSelector", attachedTo, app);
    }
    
    /**
     * 
     */
    public initialize() : void
    {
        console.log("this.app._.ui (for class " + this.app._.ui.visualization.class + ")");
        console.log(this.app._.ui);
                
        console.log("this.app._.chartConfig");
        console.log(this.app._.chartConfig[this.app._.data.numberOfMultipleDimensions].charts);
        
        this.render();
    }
    
    /**
     *
     */
    public onClick_selectorItem(event) 
    {
        var chartObject = undefined;
        
        // check if chartConfigIndex is attached to div or div's image
        if(true === _.isUndefined($(event.target).data("chartObject"))) {
            var selectorItemDiv = $($(event.target).parent());
            chartObject = selectorItemDiv.data("chartObject");
        } else {
            chartObject = $(event.target).data("chartObject");
        }
        
        console.log(chartObject);
    }
    
    /**
     *
     */
    public render() : CubeViz_View_Abstract
    {
        var numberOfMultDims = this.app._.data.numberOfMultipleDimensions,
            chartItem,
            charts = this.app._.chartConfig[numberOfMultDims].charts,
            selectorItemTpl = _.template(
                $("#cubeviz-visualizationselector-tpl-selectorItem").text()
            ),
            self = this;
        
        // load icons
        _.each(charts, function(chartObject){
            
            // create new chart item (DOM element)
            chartItem = $(selectorItemTpl(chartObject));
            
            // attach data to chart item
            chartItem
                .data("chartObject", chartObject);
                
            // If current chart object is the selected visualization ...
            if(self.app._.ui.visualization.class == chartObject.class) {
                chartItem.addClass(
                    "cubeviz-visualizationselector-selectedSelectorItem"
                );
            }
            
            // append chart item to menu
            $("#cubeviz-visualizationselector-menu")
                .append(chartItem);
        });
        
        /**
         * Delegate events to new items of the template
         */
        this.delegateEvents({
            "click .cubeviz-visualizationselector-selectorItem":
                this.onClick_selectorItem
        });
        
        return this;
    }
}