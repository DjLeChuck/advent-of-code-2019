package main

import (
	"fmt"
	"math"
	"strconv"
	"strings"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

func main() {
	in := utils.ParseInput("inputs/2024/02.txt")
	v := processInput(in)

	p1v, p1d := partOne(v)
	fmt.Printf("Part one: %d - elapsed: %s\n", p1v, p1d)
	p2v, p2d := partTwo(v)
	fmt.Printf("Part two: %d - elapsed: %s\n", p2v, p2d)
}

func processInput(in []string) [][]int {
	var r [][]int
	for _, line := range in {
		parts := strings.Fields(line)
		numbers := make([]int, len(parts))

		for i, part := range parts {
			number, err := strconv.Atoi(part)
			if err != nil {
				panic(err)
			}
			numbers[i] = number
		}
		r = append(r, numbers)
	}

	return r
}

func partOne(values [][]int) (int, string) {
	t := time.Now()
	n := 0

	for _, v := range values {
		if safe(v) {
			n++
		}
	}

	return n, time.Since(t).String()
}

func partTwo(values [][]int) (int, string) {
	t := time.Now()
	n := 0

	for _, v := range values {
		if safe(v) {
			n++
		} else {
			for i := 0; i < len(v); i++ {
				v2 := append(v[:i:i], v[i+1:]...)
				if safe(v2) {
					n++
					break
				}
			}
		}
	}

	return n, time.Since(t).String()
}

func diffOk(v, prev int) bool {
	diff := math.Abs(float64(v - prev))

	return diff >= 1 && diff <= 3
}

func safe(arr []int) bool {
	prev := arr[0]
	isIncr := arr[0] < arr[1]

	for _, v := range arr[1:] {
		if !diffOk(v, prev) {
			return false
		}

		if isIncr {
			if v < prev {
				return false
			}
		} else {
			if v > prev {
				return false
			}
		}

		prev = v
	}

	return true
}
