package utils

import (
	"bufio"
	"os"
	"strconv"
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

func CastInt(v string) int {
	i, err := strconv.Atoi(v)
	if err != nil {
		panic(err)
	}
	return i
}

func CastInt64(v string) int64 {
	i, err := strconv.ParseInt(v, 10, 64)
	if err != nil {
		panic(err)
	}
	return i
}
