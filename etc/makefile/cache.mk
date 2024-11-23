########################################################
PATH_CACHE=$(ROOT_DIR)/var/cache/
########################################################

ifeq ($(OS), Windows_NT)
    CHECK_DIR_COMMAND = if (Test-Path "$(PATH_CACHE)") { Remove-Item -Force -Recurse -ErrorAction SilentlyContinue "$(PATH_CACHE)" }
    REMOVE_COMMAND = powershell -Command "$(CHECK_DIR_COMMAND)"
else
    REMOVE_COMMAND = [ -d "$(PATH_CACHE)" ] && rm -rf $(PATH_CACHE)
endif

cache-clear:
	@$(REMOVE_COMMAND)
	@$(composer clear-cache)