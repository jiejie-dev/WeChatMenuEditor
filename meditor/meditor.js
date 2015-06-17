var menu_default = {
	                    "button": [
	                        {
	                            "type": "view", 
	                            "name": "长得帅", 
	                            "url": "http://lujiejie.com"
	                        }, 
	                        {
	                            "name": "菜单", 
	                            "sub_button": [
	                                {
	                                    "type": "view", 
	                                    "name": "百度", 
	                                    "url": "http://www.soso.com/"
	                                }, 
	                                {
	                                    "type": "view", 
	                                    "name": "腾讯视频", 
	                                    "url": "http://v.qq.com/"
	                                }, 
	                                {
	                                    "type": "view", 
	                                    "name": "腾讯网", 
	                                    "url": "http://www.qq.com/"
	                                }
	                            ]
	                        }
	                    ]
	                };
	                
function MEditor () {
	var container;
	
	var selected_top_item;
	var selected_sub_item;
	
    var menu_current;
    
	this.render = function(container_id){
		container = container_id;
		$("#"+container).load("ui.html");
	}
	
	this.loadEmpty = function(){
		this.emptyTopItems();
		this.emptySubItems();
	}
	
	this.loadDefault = function(){
		alert("1");
		menu_current = menu_default;
		this.loadMenu(menu_current);
		alert("2");
	}
	
	this.loadRemote = function(url) {
		var menu_json = $.getJSON(url);
		var menu = JSON.parse(menu_json);
		return loadMenu(menu);
	}
	
	this.loadMenu = function(menu) {
		this.loadEmpty();
		for(var i=0; i<menu.button.length; i++){
			var addItem = $("<li class=\"list-group-item top_level_item\"></li>").appendTo($(".top_level_box .list-group"));
			$(addItem).text(menu_default.button[i].name);
			$(addItem).attr("id","top_level_item_id_" + i);
			this.resgister();
		}
	}
	
	this.emptyTopItems = function () {
		$(".top_level_item").each(function(index){
			$(this).remove();
		});
	}
	
	this.emptySubItems = function () {
		$(".sub_level_item").each(function(index){
			$(this).remove();
		});
	}
	
	this.registerTopItem = function (item) {
		$(item).click(function (){
			$(".top_level_box .top_level_item").each(function(index){
				$(this).css("background-color","white");
			});
			$(this).css("background-color","yellow");
			selected_top_item = $(this);
			this.subItemEmpty();
			var index = parseInt($(this).attr("id").replace("top_level_item_id_",""));
			
			$(".sub_level_manager").find("font").text(menu_current.button[index].name);

			if(menu_current.button[index].hasOwnProperty("type")){
				if(menu_current.button[index].type == "view"){
					if(menu_current.button[index].hasOwnProperty("url")){
						//subItemEmpty();
						//var addItem = $("<li class=\"list-group-item sub_level_item\"></li>").appendTo($(".sub_level_view .list-group"))
						//$(addItem).text(menu_current.button[index].name);
						//registerSubItem(addItem);
					}

				}
				else{
						alert("key"+menu_current.button[index].key);
				}
			}
			else{
				if(menu_current.button[index].hasOwnProperty("sub_button")){
						for(var i =0;i<menu_current.button[index].sub_button.length;i++){
						var addItem = $("<li class=\"list-group-item sub_level_item\"></li>").appendTo($(".sub_level_view .list-group"));
						$(addItem).text(menu_current.button[index].sub_button[i].name);
						this.registerSubItem(addItem);
					}	
				}
								
			}
		});
	}
	
	this.registerSubItem = function (item) {
		$(item).click(function (){
			$(".sub_level_view .sub_level_item").each(function(index){
				$(this).css("background-color","white");
			});
			$(this).css("background-color","yellow");
			selected_sub_item = $(this);
		});
	}
	
	this.deleteTopItem = function () {
		$(selected_top_item).remove();
		selected_top_item = null;
	}
	
	this.deleteSubItem = function () {
		$(selected_sub_item).remove();
		selected_sub_item = null;
	}
	
	this.saveTopMenuItem = function () {
		alert("保存成功");
		$("#itemTopEdit").modal("hide");
	}
	this.saveSubMenuItem = function () {
		alert("保存成功");
		$("#itemSubEdit").modal("hide");
	}
	this.save = function(){
		alert($(".top_level_item").length);
		alert("保存成功！");
	}

	this.addTopItem = function(){
		var addItem = $("<li class=\"list-group-item top_level_item\"></li>").appendTo($(".top_level_box .list-group"));
		$(addItem).text("新建菜单项");
		$(addItem).attr("id","top_level_item_id_" + ($(".top_level_item").length-1));
		var button = new Object();
		button.name = "新建菜单项";
		menu_current.button.push(button);
		this.registerTopItem(addItem);
	}

	this.addSubItem = function(){
		var addItem = $("<li class=\"list-group-item sub_level_item\"></li>").appendTo($(".sub_level_view .list-group"));
		$(addItem).text("temp");
		this.registerSubItem(addItem);
	}
	
	this.resgister = function () {
		$(".top_level_box .top_level_item").click(function (){
			this.registerTopItem($(this));
		});

		$(".sub_level_view .sub_level_item").click(function (){
			this.registerSubItem($(this));
		});
		
		$(".btnDeleteTopItem").click(function (){
			this.deleteTopItem();
		});
		$(".btnAddTopItem").click(function (){
			this.addTopItem();
		});
		$(".btnAddSubItem").click(function () {
			this.addSubItem();
		})
		$(".btnDeleteSubItem").click(function () {
			this.deleteSubItem();
		})
		$("#save").click(function (){
			this.save();
		});
		
		$('#itemTopEdit').on('show.bs.modal', function () {
			if(this.getTopSeletedItemIndex()>-1){
				var button = menu_current.button[this.getTopSeletedItemIndex()];
				$("#top_menu_name").val(button.name);
				if(button.hasOwnProperty("type")){
					$("#top_menu_action").val(button.type);				
				}
				else{
					$("#top_menu_action").val("sub_button");
				}
				if(button.hasOwnProperty("url")){
					$("#top_menu_content").val(button.url);				
				}	
			}
			
		});
		
		$('#itemSubEdit').on('show.bs.modal', function () {
			if(this.getSubSeletedItemIndex()>-1){
				var sub_button = menu_current.button[this.getTopSeletedItemIndex()].sub_button[this.getSubSeletedItemIndex()];
				$("#sub_menu_name").val(sub_button.name);
				if(sub_button.hasOwnProperty("type")){
					$("#sub_menu_action").val(sub_button.type);
				}
				else{
					$("#sub_menu_action").val(sub_button.type);
				}
				if(sub_button.hasOwnProperty("url")){
					$("#sub_menu_content").val(sub_button.url);
				}	
			}
			
		});
	}
}

	
	
	function isSubMenu(button) {
		if(button.hasOwnProperty("url")){
			return false;
		}
		if(button.hasWonProperty("sub_button")){
			return true;
		}
		return false;
	}

	function writeObj(obj){ 
	    var description = ""; 
	    for(var i in obj){   
	        var property=obj[i];   
	        description+=i+" = "+property+"\n";  
	    }   
	    alert(description); 
	} 