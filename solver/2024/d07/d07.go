package main

import (
	"fmt"
	"strings"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

type equation struct {
	result int
	values []int
}

func main() {
	in := utils.ParseInput("inputs/2024/07.txt")
	es := processInput(in)

	p1v, p1d := partOne(es)
	fmt.Printf("Part one: %d - elapsed: %s\n", p1v, p1d)
}

func processInput(in utils.Input) []equation {
	var e []equation

	for _, line := range in {
		p := strings.Fields(line)
		var v []int
		for _, s := range p[1:] {
			v = append(v, utils.CastInt(s))
		}
		e = append(e, equation{
			utils.CastInt(strings.TrimSuffix(p[0], ":")),
			v,
		})
	}

	return e
}

func partOne(es []equation) (int, string) {
	t := time.Now()
	r := 0

	for _, e := range es {
		if resultObtained(e) {
			r += e.result
		}
	}

	return r, time.Since(t).String()
}

func partTwo() (int, string) {
	t := time.Now()

	return 0, time.Since(t).String()
}

func generateCombinations(n int) [][]string {
	signs := []string{"+", "*"}
	var r [][]string

	var rf func(c []string, d int)
	rf = func(c []string, d int) {
		if d == n {
			cb := make([]string, len(c))
			copy(cb, c)
			r = append(r, cb)
			return
		}

		for _, s := range signs {
			rf(append(c, s), d+1)
		}
	}

	rf([]string{}, 0)
	return r
}

func resultObtained(e equation) bool {
	cb := generateCombinations(len(e.values) - 1)

	for _, o := range cb {
		x := e.values[0]
		for i, v := range e.values[1:] {
			switch o[i] {
			case "+":
				x += v
			case "*":
				x *= v
			}

			if x > e.result {
				break
			}
		}
		if x == e.result {
			return true
		}
	}

	return false
}
