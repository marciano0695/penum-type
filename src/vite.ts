import { HmrContext, Plugin } from "vite"
import laravel from "laravel-vite-plugin"
import { watchAndRun } from "vite-plugin-watch-and-run"
import { execSync } from "child_process"

export default function penum_type(): Plugin {
	return {
		name: "penum-type",
		enforce: "post",
		handleHotUpdate(ctx: HmrContext) {
			let enumPath = "app/Enums"
			try {
				enumPath = execSync("php artisan penum-type:path").toString().trim()
			} catch (e) {
				console.warn(
					"[penum-type] Could not determine enum path:",
					(e as Error).message
				)
			}

			watchAndRun([
				{
					name: "watch-enums",
					watch: `${enumPath}/**/*.php`,
					run: "php artisan penum-type:generate",
				},
			])
		},
	}
}
