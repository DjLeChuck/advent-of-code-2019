package main

import (
	"fmt"
	"regexp"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

func main() {
	in := utils.ParseInput("inputs/2024/03.txt")

	p1v, p1d := partOne(in)
	fmt.Printf("Part one: %d - elapsed: %s\n", p1v, p1d)
	p2v, p2d := partTwo(in)
	fmt.Printf("Part two: %d - elapsed: %s\n", p2v, p2d)
}

func partOne(in utils.Input) (int, string) {
	re := regexp.MustCompile(`mul\((\d{1,3}),(\d{1,3})\)`)
	t := time.Now()
	n := 0

	for _, line := range in {
		m := re.FindAllStringSubmatch(line, -1)
		for _, v := range m {
			n += utils.CastInt(v[1]) * utils.CastInt(v[2])
		}
	}

	return n, time.Since(t).String()
}

func partTwo(in utils.Input) (int, string) {
	re := regexp.MustCompile(`(do(?:n't)?\(\)|mul\((\d{1,3}),(\d{1,3})\))`)
	t := time.Now()
	n := 0
	allowed := true

	for _, line := range in {
		m := re.FindAllStringSubmatch(line, -1)
		for _, v := range m {
			if "don't()" == v[1] {
				allowed = false
				continue
			}

			if "do()" == v[1] {
				allowed = true
				continue
			}

			if !allowed {
				continue
			}

			n += utils.CastInt(v[2]) * utils.CastInt(v[3])
		}
	}

	return n, time.Since(t).String()
}
