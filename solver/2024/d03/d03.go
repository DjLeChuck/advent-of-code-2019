package main

import (
	"fmt"
	"regexp"
	"strconv"
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

func partOne(in []string) (int, string) {
	re, err := regexp.Compile(`mul\((\d{1,3}),(\d{1,3})\)`)
	if err != nil {
		panic(err)
	}

	t := time.Now()
	n := 0

	for _, line := range in {
		m := re.FindAllStringSubmatch(line, -1)
		for _, v := range m {
			vl, err := strconv.Atoi(v[1])
			if err != nil {
				panic(err)
			}
			vr, err := strconv.Atoi(v[2])
			if err != nil {
				panic(err)
			}

			n += vl * vr
		}
	}

	return n, time.Since(t).String()
}

func partTwo(in []string) (int, string) {
	re, err := regexp.Compile(`(do(?:n't)?\(\)|mul\((\d{1,3}),(\d{1,3})\))`)
	if err != nil {
		panic(err)
	}

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

			vl, err := strconv.Atoi(v[2])
			if err != nil {
				panic(err)
			}
			vr, err := strconv.Atoi(v[3])
			if err != nil {
				panic(err)
			}

			n += vl * vr
		}
	}

	return n, time.Since(t).String()
}
