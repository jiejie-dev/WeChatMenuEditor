var debug_mode = true;
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

	
	var selected_top_item;
	var selected_sub_item;
	
    var menu_current;

	$(document).ready(function (){
		loadEmpty();
		loadLocal();
		
		resgister();
		
		$(".btnDeleteTopItem").click(function (){
			deleteTopItem();
		});
		$(".btnAddTopItem").click(function (){
			addTopItem();
		});
		$(".btnAddSubItem").click(function () {
			addSubItem();
		})
		$(".btnDeleteSubItem").click(function () {
			deleteSubItem();
		})
		$("#save").click(function (){
			save();
		});
		$('#itemTopEdit').on('show.bs.modal', function () {
			if(getTopSeletedItemIndex()>-1){
				var button = menu_current.button[getTopSeletedItemIndex()];
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
			if(getSubSeletedItemIndex()>-1){
				var sub_button = menu_current.button[getTopSeletedItemIndex()].sub_button[getSubSeletedItemIndex()];
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
	});
	
	function getTopSeletedItemIndex() {
		return getTopItemIndex(selected_top_item);
	}
	
	function getTopItemIndex(item) {
		var item_index = -1;
		$(".top_level_item").each(function(index) {
			if($(item).text()==$(this).text()){
				item_index = index;
				return false;
			}
		});
		return item_index;
	}
	
	function getSubSeletedItemIndex() {
		return getSubItemIndex(selected_sub_item);
	}
	
	function getSubItemIndex(item) {
		var item_index = -1;
		$(".sub_level_item").each(function(index) {
			if($(item).text()==$(this).text()){
				item_index = index;
				return false;
			}
		});
		return item_index;
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
	
	function saveTopMenuItem() {
		menu_current.button[getTopSeletedItemIndex()] = new Object();
		var current = menu_current.button[getTopSeletedItemIndex()];
		current.name = $("#top_menu_name").val();
		if($("#top_menu_action").val() == "sub_button"){
			current.sub_button = [];
		}
		else{
			current.type = $("#top_menu_action").val();
			current.url = $("#top_menu_content").val();
		}
		
		$("#itemTopEdit").modal("hide");
		
		DebugLog("save top menu item :");
		DebugLog(JSON.stringify(menu_current));
		
		saveLocal();
	}
	
	function saveSubMenuItem() {
		menu_current.button[getTopSeletedItemIndex()].sub_button[getSubSeletedItemIndex()] = new Object();
		var current = menu_current.button[getTopSeletedItemIndex()].sub_button[getSubSeletedItemIndex()];
		current.name = $("#sub_menu_name").val();
		current.type = $("#sub_menu_action").val();
		if(current.type == "click"){
			current.key = $("#sub_menu_content").val();
		}
		else{
			current.url = $("#sub_menu_content").val();
		}
		$("#itemSubEdit").modal("hide");
		
		DebugLog("save sub menu item :");
		DebugLog(JSON.stringify(menu_current));
		
		saveLocal();
	}
	
	function saveLocal(){
		localStorage.WX_MENU = JSON.stringify(menu_current);	
		DebugLog("save local successed !");
	}
	
	function save(){
		DebugLog(JSON.stringify(menu_current));
		saveLocal();
		alert("保存成功！");
	}

	function loadEmpty(){
		menu_current = {
			"button":[]
		};
		emptyTopItemHtml();
		emptySubItemHtml();
	}
	
	function loadLocal () {
		if(window.localStorage){
			if(localStorage.WX_MENU){
				DebugLog("local menu :")
				DebugLog(localStorage.WX_MENU);
				var menu = JSON.parse(localStorage.WX_MENU);
				loadMenu(menu);
			}
			else{
				DebugLog("do not exist local menu");
			}
		}
		else{
			DebugLog("browser don't support localStorage");
		}
	}
	
	function clearLocal() {
		localStorage.removeItem("WX_MENU");
		loadEmpty();
	}
	
	function emptyTopItemHtml () {
		$(".top_level_item").each(function(index){
			$(this).remove();
		});
	}
	
	function emptySelectedTopItemData () {
		if(menu_current.button.length>0){
				menu_current.button.splice(getTopSeletedItemIndex(),1);				
		}
	}
	
	function emptySelectedSubItemData () {
		if(menu_current.hasOwnProperty("button")){
				if(menu_current.button.length>0){
					var current_button = menu_current.button[getTopSeletedItemIndex()]; 
					if(current_button.hasOwnProperty("sub_button")){
						if(menu_current.button[getTopSeletedItemIndex()].sub_button.length>0){
							menu_current.button[getTopSeletedItemIndex()].sub_button.splice(getSubSeletedItemIndex(),1);
						}
					}		
				}
			}
	}
	
	function emptySubItemHtml(){
		$(".sub_level_item").each(function(index){
			$(this).remove();
		});
	}
	
	function loadDefault(){
		loadMenu(menu_default);
	}

	function loadMenu(menu){
		DebugLog(JSON.stringify(menu));
		menu_current = menu;
		emptyTopItemHtml();
		emptySubItemHtml();
		for(var i=0; i<menu.button.length; i++){
			var addItem = $("<li class=\"list-group-item top_level_item\"></li>").appendTo($(".top_level_box .list-group"));
			$(addItem).text(menu.button[i].name);
			$(addItem).attr("id","top_level_item_id_" + i);
			resgister();
		}
	}

	function addTopItem(){
		var addItem = $("<li class=\"list-group-item top_level_item\"></li>").appendTo($(".top_level_box .list-group"));
		$(addItem).text("一级菜单");
		$(addItem).attr("id","top_level_item_id_" + ($(".top_level_item").length-1));
		var button = new Object();
		button.name = "一级菜单";
		menu_current.button.push(button);
		registerTopItem(addItem);
	}

	function addSubItem(){
		var addItem = $("<li class=\"list-group-item sub_level_item\"></li>").appendTo($(".sub_level_view .list-group"));
		$(addItem).text("二级菜单");
		var sub_button = new Object();
		sub_button.name = "二级菜单";
		menu_current.button[getTopSeletedItemIndex()].sub_button.push(sub_button);
		registerSubItem(addItem);
	}
	
	function deleteTopItem(){
		$(selected_top_item).remove();
		selected_top_item = null;
	}

	function deleteSubItem(){
		$(selected_sub_item).remove();
		selected_sub_item = null;
	}

	function registerTopItem(item){
		$(item).click(function (){
			$(".top_level_box .top_level_item").each(function(index){
				$(this).css("background-color","white");
			});
			$(this).css("background-color","yellow");
			selected_top_item = $(this);
			emptySubItemHtml();
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
						registerSubItem(addItem);
					}	
				}
			}
		});
	}
	
	function registerSubItem(item){
		$(item).click(function (){
			$(".sub_level_view .sub_level_item").each(function(index){
				$(this).css("background-color","white");
			});
			$(this).css("background-color","yellow");
			selected_sub_item = $(this);
		});
	}
	
	function resgister(){
		$(".top_level_box .top_level_item").click(function (){
				registerTopItem($(this));
		});

		$(".sub_level_view .sub_level_item").click(function (){
			registerSubItem($(this));
		});
	}
	
	function writeObj(obj){ 
	    var description = ""; 
	    for(var i in obj){   
	        var property=obj[i];   
	        description+=i+" = "+property+"\n";  
	    }   
	    alert(description); 
	} 
	
	function DebugLog (message) {
		if(debug_mode){
			console.log(message);
		}
	}