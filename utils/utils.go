package utils

import (
	"bufio"
	"os"
)

type Input []string

func ParseInput(input string) Input {
	file, err := os.Open(input)
	if err != nil {
		panic(err)
	}
	defer file.Close()

	var results Input
	scan := bufio.NewScanner(file)
	for scan.Scan() {
		results = append(results, scan.Text())
	}

	if err = scan.Err(); err != nil {
		panic(err)
	}

	return results
}
