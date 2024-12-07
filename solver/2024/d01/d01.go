package main

import (
	"fmt"
	"math"
	"regexp"
	"slices"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

func main() {
	in := utils.ParseInput("inputs/2024/01.txt")
	l, r := processInput(in)

	p1v, p1d := partOne(l, r)
	fmt.Printf("Part one: %.0f - elapsed: %s\n", p1v, p1d)
	p2v, p2d := partTwo(l, r)
	fmt.Printf("Part two: %d - elapsed: %s\n", p2v, p2d)
}

func processInput(in utils.Input) ([]int, []int) {
	re := regexp.MustCompile(`(\d+) +(\d+)`)

	var l, r []int
	for _, line := range in {
		v := re.FindStringSubmatch(line)
		if len(v) != 3 {
			panic(fmt.Sprintf("cannot match two numbers in \"%s\"", line))
		}

		l = append(l, utils.CastInt(v[1]))
		r = append(r, utils.CastInt(v[2]))
	}

	slices.Sort(l)
	slices.Sort(r)

	return l, r
}

func partOne(l []int, r []int) (float64, string) {
	t := time.Now()
	d := 0.0
	for i, vl := range l {
		vr := r[i]

		d += math.Abs(float64(vl - vr))
	}
	return d, time.Since(t).String()
}

func partTwo(l []int, r []int) (int, string) {
	t := time.Now()
	d := 0
	for _, v := range l {
		d += v * count(r, v)
	}
	return d, time.Since(t).String()
}

func count(s []int, v int) int {
	c := 0
	for _, l := range s {
		if l == v {
			c++
		}
	}
	return c
}
