package main

import (
	"bufio"
	"fmt"
	"math"
	"os"
	"regexp"
	"slices"
	"strconv"
)

func main() {
	l, r := parseInput("inputs/2024/01.txt")

	fmt.Printf("Part one: %f\n", partOne(l, r))
	fmt.Printf("Part two: %d\n", partTwo(l, r))
}

func parseInput(in string) ([]int, []int) {
	file, err := os.Open(in)
	if err != nil {
		panic(err)
	}
	defer file.Close()

	re, err := regexp.Compile(`(\d+) +(\d+)`)
	if err != nil {
		panic(err)
	}

	var l, r []int
	scan := bufio.NewScanner(file)
	for scan.Scan() {
		v := re.FindStringSubmatch(scan.Text())
		if len(v) != 3 {
			panic(fmt.Sprintf("cannot match two numbers in \"%s\"", l))
		}

		vl, err := strconv.Atoi(v[1])
		if err != nil {
			panic(err)
		}
		vr, err := strconv.Atoi(v[2])
		if err != nil {
			panic(err)
		}
		l = append(l, vl)
		r = append(r, vr)
	}

	if err = scan.Err(); err != nil {
		panic(err)
	}

	slices.Sort(l)
	slices.Sort(r)

	return l, r
}

func partOne(l []int, r []int) float64 {
	d := 0.0
	for i, vl := range l {
		vr := r[i]

		d += math.Abs(float64(vl - vr))
	}
	return d
}

func partTwo(l []int, r []int) int {
	d := 0
	for _, v := range l {
		d += v * count(r, v)
	}
	return d
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
