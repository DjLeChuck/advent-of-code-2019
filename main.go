package main

import (
	"fmt"
	"time"
)

func main() {
	t := time.Now()
	fmt.Printf("usage: directly call the desired solver.\n\nfor example: go run solver/%d/d%02d.go", t.Year(), t.Day())
}
