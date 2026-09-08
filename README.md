# Path Traversal CTF — DocuShare

A deliberately vulnerable PHP web app built for learning and practicing **Path Traversal** exploitation and mitigation, level by level.

Repo: [0xElghobashy/path-traversal-ctf](https://github.com/0xElghobashy/path-traversal-ctf)

> ⚠️ **For local/isolated lab use only.** This app is intentionally insecure. Never deploy it on a public server or network.

## Scenario

DocuShare is a fictional internal company tool that lets employees download invoices from a `documents/` folder. Files are requested via a `file` GET parameter, e.g.:

```
download.php?file=invoice1.txt
```

The goal across each level is to read `secret/config.txt` — a file that sits **outside** the intended `documents/` folder and represents a sensitive file an attacker shouldn't be able to reach.

## Project Structure

```
docushare_php/
├── index.php          # Lists available invoices, links to download.php
├── download.php        # Vulnerable endpoint (evolves across levels)
├── css/
│   └── style.css
├── documents/           # Intended, "safe" folder
│   ├── invoice1.txt
│   ├── invoice2.txt
│   └── invoice3.txt
└── secret/
    └── config.txt       # Target file — should never be reachable via download.php
```

## Levels

### Level 1 — No Protection (current)

`download.php` concatenates user input directly into the file path with no validation:

```php
$file = $_GET['file'];
$path = __DIR__ . '/documents/' . $file;
```

Only `file_exists()` is checked — not whether the resolved path is still inside `documents/`. Any `../` sequence lets the attacker escape the intended folder.

**Exploit:**
```
download.php?file=../secret/config.txt
```

### Level 2 — Blacklist Filter *(planned)*

Add a naive filter that blocks the literal string `../`, and demonstrate common bypass techniques (encoding, double `../` tricks, absolute paths, etc.).

### Level 3 — Path Normalization *(planned)*

Strip `../` with a regex/replace approach that's still bypassable, and show why single-pass sanitization fails.

### Level 4 — Proper Fix *(planned)*

Use `realpath()` + prefix checking (or a whitelist) to correctly confine access to `documents/`.

## Setup

1. Clone the repo into your web server's document root:
   ```bash
   git clone https://github.com/0xElghobashy/path-traversal-ctf.git
   ```
2. Ensure the web server user (e.g. `www-data`) owns the files:
   ```bash
   sudo chown -R www-data:www-data path-traversal-ctf
   sudo chmod -R 755 path-traversal-ctf
   ```
3. Browse to `index.php` via your local server (e.g. `http://localhost/path-traversal-ctf/`).

## Disclaimer

Built strictly for educational purposes — to practice identifying, exploiting, and fixing Path Traversal vulnerabilities in a controlled environment.
