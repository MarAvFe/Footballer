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
    
    cell0.innerHTML = "Goal";
    cell1.appendChild(getComboPlayers());
    cell2.appendChild(getMinsInput());
    cell3.innerHTML = "--";
    cell4.appendChild(penalty);
    cell5.innerHTML = "--";
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
    
    cell0.innerHTML = "Card";
    cell1.appendChild(getComboPlayers());
    cell2.appendChild(getMinsInput());
    cell3.appendChild(getCardColorsCombo());
    cell4.innerHTML = "--";
    cell5.innerHTML = "--";
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
    direct.setAttribute("class","form-control");
    
    cell0.innerHTML = "Attempt";
    cell1.appendChild(getComboPlayers());
    cell2.appendChild(getMinsInput());
    cell3.innerHTML = "--";
    cell4.innerHTML = "--";
    cell5.appendChild(direct);
}

function addCorner(tableId){
    var table = document.getElementById(tableId);
    var row = table.insertRow(1);
    
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    var cell5 = row.insertCell(5);
    
    cell0.innerHTML = "Corner";
    cell1.appendChild(getComboPlayers());
    cell2.innerHTML = "--";
    cell3.innerHTML = "--";
    cell4.innerHTML = "--";
    cell5.innerHTML = "--";
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
        
    cell0.innerHTML = "Save";
    cell1.appendChild(getComboPlayers());
    cell2.innerHTML = "--";
    cell3.innerHTML = "--";
    cell4.innerHTML = "--";
    cell5.innerHTML = "--";;
}

function getComboPlayers(){
    var queriedPlayers = ["Raul","Morientes","Figo","Ronaldo","Totti"]
    var optionPlayers;
    
    var players = document.createElement("SELECT");
    for(i = 0; i < 4; i++){
        optionPlayers = document.createElement("option");
        optionPlayers.text = queriedPlayers[i];
        optionPlayers.value = queriedPlayers[i];
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
    
    return mins;
}

function getCardColorsCombo(){
     var combo = document.createElement("SELECT");
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
