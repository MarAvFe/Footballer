function addCombo(comboId, inputId) {
    var textb = document.getElementById(inputId);
    var combo = document.getElementById(comboId);

    var option = document.createElement("option");
    option.text = textb.value;
    option.value = textb.value;
    try {
        combo.add(option, null); //Standard 
    }catch(error) {
        combo.add(option); // IE only
    }
    textb.value = "";
}

function removeOptionsByValue(selectBox, value){
    for (var i = selectBox.length - 1; i >= 0; --i) {
        if (selectBox[i].value == value) {
        selectBox.remove(i);
        }
    }
}

function deleteCombo(comboId) {
    var combo = document.getElementById(comboId);
    var toDelete = combo.options[combo.selectedIndex].text;

    removeOptionsByValue(combo, toDelete);
}

function addGoal(tableId){
    var table = document.getElementById(tableId);
    var row = table.insertRow(1);
    
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    var cell5 = row.insertCell(5);
    
    var penalty = document.createElement("INPUT");
    penalty.setAttribute("type","checkbox");
    penalty.setAttribute("class","form-control");
    penalty.setAttribute("name","newStat[]");
    penalty.setAttribute("value","off");
    
    cell0.appendChild(getStatTitle("Goal"));
    cell1.appendChild(getComboPlayers());
    cell2.appendChild(getMinsInput());
    cell3.innerHTML = "--";
    cell4.appendChild(penalty);
    cell5.innerHTML = "--";
    $('.selectpicker').selectpicker('refresh');
}

function addCard(tableId){
    var table = document.getElementById(tableId);
    var row = table.insertRow(1);
    
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    var cell5 = row.insertCell(5);
    
    cell0.appendChild(getStatTitle("Card"))
    cell1.appendChild(getComboPlayers());
    cell2.innerHTML = "--";
    cell3.appendChild(getCardColorsCombo());
    cell4.innerHTML = "--";
    cell5.innerHTML = "--";
    $('.selectpicker').selectpicker('refresh');
}

function addAttempt(tableId){
    var table = document.getElementById(tableId);
    var row = table.insertRow(1);
    
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    var cell5 = row.insertCell(5);
    
    var direct = document.createElement("INPUT");
    direct.setAttribute("type","checkbox");
    direct.setAttribute("class","form-control ");
    direct.setAttribute("name","newStat[]");
    direct.setAttribute("value","off");
    
    cell0.appendChild(getStatTitle("Attempt"))
    cell1.innerHTML = "--";
    cell2.innerHTML = "--";
    cell3.innerHTML = "--";
    cell4.innerHTML = "--";
    cell5.appendChild(direct);
}

function addSave(tableId){
    var table = document.getElementById(tableId);
    var row = table.insertRow(1);
    
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    var cell5 = row.insertCell(5);
        
    cell0.appendChild(getStatTitle("Save"))
    cell1.appendChild(getComboPlayers());
    cell2.innerHTML = "--";
    cell3.innerHTML = "--";
    cell4.innerHTML = "--";
    cell5.innerHTML = "--";
    $('.selectpicker').selectpicker('refresh');
    
}

function getComboPlayers(){
    var optionPlayers;
    var localQPlays = window.queriedPlayers;
    var localQIds = window.queriedIds;
    
    var players = document.createElement("SELECT");
    players.setAttribute("name","newStat[]");
    players.setAttribute("class","selectpicker");
    players.setAttribute("data-live-search","true");
    players.setAttribute("title","Select a player");
    
    for(i = 0; i < localQIds.length; i++){
        optionPlayers = document.createElement("option");
        optionPlayers.text = localQPlays[i];
        optionPlayers.value = localQIds[i];
        players.add(optionPlayers);
    }
    return players;
}

function getMinsInput(){
    var mins = document.createElement("INPUT");
    mins.setAttribute("type","number");
    mins.setAttribute("class","form-control");
    mins.setAttribute("placeholder","0");
    mins.setAttribute("min","0");
    mins.setAttribute("max","120");
    mins.setAttribute("step","1");
    mins.setAttribute("name","newStat[]");
    
    return mins;
}

function getCardColorsCombo(){
    var combo = document.createElement("SELECT");
    combo.setAttribute("name","newStat[]");
    combo.setAttribute("class","selectpicker");
    combo.setAttribute("title","Color");
    combo.setAttribute("data-width","80px");
    var option1 = document.createElement("option");
    option1.text = "Yellow";
    option1.value = "0";
    
    var option2 = document.createElement("option");
    option2.text = "Red";
    option2.value = "1";
    
    try {
        combo.add(option1, null); //Standard 
        combo.add(option2, null); //Standard 
    }catch(error) {
        combo.add(option1); // IE only
        combo.add(option2); // IE only
    }
    
    return combo;
}


function getStatTitle(title){
    var combo = document.createElement("input");
    combo.setAttribute("name","newStat[]");
    combo.setAttribute("class","statType");
    combo.setAttribute("value",title);
    combo.setAttribute("readonly","readonly");
    return combo;
}
