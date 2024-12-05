.DEFAULT_GOAL := help
.PHONY:help fmt vet

## help: print this help message
help:
	@echo 'Usage:'
	@sed -n 's/^##//p' ${MAKEFILE_LIST} | column -t -s ':' |  sed -e 's/^/ /'

## fmt: format code
fmt:
	go fmt ./...

## vet: format code and execute got vet
vet: fmt
	go vet ./...

## test: test code
test:
	go clean -testcache && go test ./...
