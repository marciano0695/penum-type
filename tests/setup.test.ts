import { describe, it, expect, vi, beforeEach } from "vitest"
import penum_type from "../src/vite"
import { watchAndRun } from "vite-plugin-watch-and-run"
import { execSync } from "child_process"
import { HmrContext } from "vite"

vi.mock("child_process", () => ({
	execSync: vi.fn(),
}))

vi.mock("vite-plugin-watch-and-run", () => ({
	watchAndRun: vi.fn(),
}))

describe("penum_type plugin", () => {
	beforeEach(() => {
		vi.clearAllMocks()
	})

	it("should have correct name and enforce", () => {
		const plugin = penum_type()
		expect(plugin.name).toBe("penum-type")
		expect(plugin.enforce).toBe("post")
	})

	it("should use default enum path when command fails", () => {
		vi.mocked(execSync).mockImplementation(() => {
			throw new Error("Command failed")
		})

		const plugin = penum_type()
		const handler =
			typeof plugin.handleHotUpdate === "function"
				? plugin.handleHotUpdate.bind({} as any)
				: plugin.handleHotUpdate?.handler?.bind({} as any)
		handler?.({} as HmrContext)

		expect(watchAndRun).toHaveBeenCalledWith([
			{
				name: "watch-enums",
				watch: "app/Enums/**/*.php",
				run: "php artisan penum-type:generate",
			},
		])
	})

	it("should use custom enum path when command succeeds", () => {
		vi.mocked(execSync).mockReturnValue("custom/path\n")

		const plugin = penum_type()
		const handler =
			typeof plugin.handleHotUpdate === "function"
				? plugin.handleHotUpdate.bind({} as any)
				: plugin.handleHotUpdate?.handler?.bind({} as any)
		handler?.({} as HmrContext)

		expect(watchAndRun).toHaveBeenCalledWith([
			{
				name: "watch-enums",
				watch: "custom/path/**/*.php",
				run: "php artisan penum-type:generate",
			},
		])
	})
})
