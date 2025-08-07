# To generate typescript files

```bash
php artisan penum-type:generate
```

# Hot-reload

1. Install the watcher plugin

```bash
npm install --save-dev vite-plugin-watch-and-run
```

2. Add Plugin to vite.config.js
   Open your Laravel app’s vite.config.js file and update it like so:

```js
import { defineConfig } from "vite"
import laravel from "laravel-vite-plugin"
import { watchAndRun } from "vite-plugin-watch-and-run"
import { execSync } from "child_process"

// Dynamically resolve enum path from your Laravel config
let enumPath = "app/Enums" // fallback default
try {
	enumPath = execSync("php artisan penum-type:path").toString().trim()
} catch (e) {
	console.warn(
		"[penum-type] Could not determine enum path from config:",
		e.message
	)
}

export default defineConfig({
	plugins: [
		laravel({
			input: ["resources/css/app.css", "resources/js/app.js"],
			refresh: true,
		}),
		watchAndRun([
			{
				name: "watch-enums",
				watch: `${enumPath}/**/*.php`,
				run: "php artisan penum-type:generate",
			},
		]),
	],
})
```

Change detected in app/Enums/Status.php
```bash
> php artisan enum-generator:generate
> Enum generation complete.
```
