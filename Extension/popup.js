// Copyright 2018 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.

'use strict';

let changeColor = document.getElementById('changeColor');
chrome.storage.sync.get('color', function(data) {
  changeColor.style.backgroundColor = data.color;
  changeColor.setAttribute('value', data.color);
});




var finalcode = '
var box = document.createElement("div");
box.setAttribute("id","p2");
var xd = document.createTextNode("click me");
box.appendChild(xd);
box.style.width = "200px";
box.style.height = "200px";
box.style.backgroundColor = "blue";
box.style.position = "fixed";
box.style.bottom = "0";
box.style.right = "0";
var btn = document.createElement("BUTTON");
box.appendChild(btn);
var btnt = document.createTextNode("hej");
btn.appendChild(btnt);
box.style.position = "fixed";
box.style.bottom = "0px";
btn.style.width = "100px";
btn.style.height = "50px";
btn.style.backgroundColor = "green";
document.body.appendChild(box);
';

changeColor.onclick = function(element) {
    let color = element.target.value;
    chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {
        chrome.tabs.executeScript(
        tabs[0].id,
        {code: finalcode});
    });
};