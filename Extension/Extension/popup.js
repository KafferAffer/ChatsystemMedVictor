// Copyright 2018 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.
    

//this was a bad idea to include
//alert("gib 12");

//laver outline til chatten
var $fixed = document.createElement( "div" );
$fixed.style = "position: fixed; bottom: 0; right: 0; width: 200px; height: 200px; border: 3px solid #73AD21;background-color: #ffffff;";

var $beskeder = document.createElement( "div" );
$beskeder.style = "position: absolute;top: 10%;height: 80%px;width: 100%;";
$beskeder.append("her er beskeder");

var $chatnavn = document.createElement( "div" );
$chatnavn.style = "position: absolute;top: 0px;height: 10%px;width: 100%;border: 1px solid #73AD21;";
$chatnavn.append("Chat navn");

var $beskedsender = document.createElement( "div" );
$beskedsender.style = "position: absolute;bottom: 1px;height: 10%;width: 100%;border: 1px solid #73AD21;";

$sendknap = document.createElement( "button" );
$sendknap.style = "position: absolute;right: 0%;height: 100%;width: 20%;";
$sendknap.append("Send");
$sendknap.id = "sendbuttonsabsurdstringthatsneverused";

$textfelt = document.createElement( "input" );
$textfelt.style = "position: absolute;left: 0%;height: 100%;width: 80%;border: 1px solid #73AD21;";
$textfelt.placeholder = "skriv her";
$textfelt.id = "textfieldsabsurdstringthatsneverused";

$beskedsender.append($sendknap);
$beskedsender.append($textfelt);


$fixed.append($beskedsender);
$fixed.append($beskeder);
$fixed.append($chatnavn);
$($fixed).appendTo("body");

$('#sendbuttonsabsurdstringthatsneverused').click(function(e){
    alert("pikachu used: "+$('#textfieldsabsurdstringthatsneverused').val());
    $('#textfieldsabsurdstringthatsneverused').val('');
    return false;
});
