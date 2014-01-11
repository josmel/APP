/*=========================================================================================
 *@ListModules: Listado de todos los Modulos asociados al portal
 **//*===================================================================================*/
yOSON.AppSchema.modules = {
    'Event': {
        controllers:{
            'index':{
                actions : {
                    'index' : function(){
                        yOSON.AppCore.runModule('calendar');
                    },
                    'byDefault':function(){}
                },
                allActions:function(){}
            },
            byDefault : function(){},
            allActions: function(){}
        },
        byDefault : function(){},
        allControllers : function(){}
    },
    'SanAuth': {
        controllers:{     
            'Auth':{
                actions : {
                    'login' : function(){
                        yOSON.AppCore.runModule('validation',{'form':"#usarioAut"});
                    },
                    'byDefault':function(){}
                },
                allActions:function(){}
            },
            byDefault : function(){},
            allActions: function(){}
        },
        byDefault : function(){},
        allControllers : function(){}
    },
    byDefault : function(){},
    allModules : function(oMCA){
        yOSON.AppCore.runModule('alerts');
    }
};