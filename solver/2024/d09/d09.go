package main

import (
	"fmt"
	"slices"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

type blocks []any

func main() {
	in := utils.ParseInput("inputs/2024/09.txt")
	b := processInput(in)

	p1v, p1d := partOne(b)
	fmt.Printf("Part one: %d - elapsed: %s\n", p1v, p1d)
}

func processInput(in utils.Input) blocks {
	var r blocks
	var id int

	for _, l := range in {
		for i, c := range l {
			v := utils.CastInt(string(c))
			if v == 0 {
				continue
			}

			isFile := i%2 == 0

			r = append(r, expand(id, v, isFile)...)

			if isFile {
				id++
			}
		}
	}

	return r
}

func partOne(b blocks) (int, string) {
	t := time.Now()

	for i := len(b) - 1; i >= 0; i-- {
		v := b[i]
		fsi := slices.Index(b, ".")

		if v != "." {
			b[fsi] = v
			b[i] = "."
		}

		if spaceAllEnd(b) {
			break
		}
	}

	s := 0
	for i, v := range b {
		if v == "." {
			break
		}

		s += i * v.(int)
	}

	return s, time.Since(t).String()
}

func partTwo() (int, string) {
	t := time.Now()

	return 0, time.Since(t).String()
}

func expand(id, v int, isFile bool) blocks {
	var r blocks

	for i := 0; i < v; i++ {
		if isFile {
			r = append(r, id)
		} else {
			r = append(r, ".")
		}
	}

	return r
}

func spaceAllEnd(b blocks) bool {
	fs := false

	for _, v := range b {
		if v == "." {
			fs = true
		} else if fs {
			return false
		}
	}

	return true
}
