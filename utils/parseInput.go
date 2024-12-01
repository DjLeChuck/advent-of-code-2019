package utils

import (
	"bufio"
	"os"
)

func ParseInput(input string) []string {
	file, err := os.Open(input)
	if err != nil {
		panic(err)
	}
	defer file.Close()

	var results []string
	scan := bufio.NewScanner(file)
	for scan.Scan() {
		results = append(results, scan.Text())
	}

	if err = scan.Err(); err != nil {
		panic(err)
	}

	return results
}
