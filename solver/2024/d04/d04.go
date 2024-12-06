package main

import (
	"fmt"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

type coord [2]int
type xmasCoord [4]coord
type masCoord [3]coord
type grid map[coord]string

var (
	xmas = [4]string{"X", "M", "A", "S"}
	mas  = [3]string{"M", "A", "S"}
)

func main() {
	in := utils.ParseInput("inputs/2024/04.txt")
	g := processInput(in)

	p1v, p1d := partOne(g)
	fmt.Printf("Part one: %d - elapsed: %s\n", p1v, p1d)
}

func processInput(in utils.Input) grid {
	m := make(grid)
	for y, r := range in {
		for x, c := range r {
			m[coord{x, y}] = string(c)
		}
	}
	return m
}

func partOne(g grid) (int, string) {
	t := time.Now()
	var n int

	for coord, c := range g {
		if "X" == c {
			n += countXmas(g, coord)
		}
	}

	return n, time.Since(t).String()
}

func partTwo(g grid) (int, string) {
	t := time.Now()
	var n int

	for coord, c := range g {
		if "M" == c {
			n += countXMas(g, coord)
		}
	}

	return n, time.Since(t).String()
}

func countXmas(g grid, c coord) int {
	rtl := xmasCoord{
		c,
		{c[0] - 1, c[1]},
		{c[0] - 2, c[1]},
		{c[0] - 3, c[1]},
	}
	ltr := xmasCoord{
		c,
		{c[0], c[1] + 1},
		{c[0], c[1] + 2},
		{c[0], c[1] + 3},
	}
	utb := xmasCoord{
		c,
		{c[0] + 1, c[1]},
		{c[0] + 2, c[1]},
		{c[0] + 3, c[1]},
	}
	btu := xmasCoord{
		c,
		{c[0], c[1] - 1},
		{c[0], c[1] - 2},
		{c[0], c[1] - 3},
	}
	dtl := xmasCoord{
		c,
		{c[0] - 1, c[1] - 1},
		{c[0] - 2, c[1] - 2},
		{c[0] - 3, c[1] - 3},
	}
	dtr := xmasCoord{
		c,
		{c[0] + 1, c[1] - 1},
		{c[0] + 2, c[1] - 2},
		{c[0] + 3, c[1] - 3},
	}
	dbl := xmasCoord{
		c,
		{c[0] - 1, c[1] + 1},
		{c[0] - 2, c[1] + 2},
		{c[0] - 3, c[1] + 3},
	}
	dbr := xmasCoord{
		c,
		{c[0] + 1, c[1] + 1},
		{c[0] + 2, c[1] + 2},
		{c[0] + 3, c[1] + 3},
	}

	var n int

	if isXmas(g, rtl) {
		n++
	}
	if isXmas(g, ltr) {
		n++
	}
	if isXmas(g, utb) {
		n++
	}
	if isXmas(g, btu) {
		n++
	}
	if isXmas(g, dtl) {
		n++
	}
	if isXmas(g, dtr) {
		n++
	}
	if isXmas(g, dbl) {
		n++
	}
	if isXmas(g, dbr) {
		n++
	}

	return n
}

func isXmas(g grid, c xmasCoord) bool {
	for i, coord := range c {
		if g[coord] != xmas[i] {
			return false
		}
	}

	return true
}

func countXMas(g grid, c coord) int {
	dtl := masCoord{
		c,
		{c[0] - 1, c[1] - 1},
		{c[0] - 2, c[1] - 2},
	}
	dtr := masCoord{
		c,
		{c[0] + 1, c[1] - 1},
		{c[0] + 2, c[1] - 2},
	}
	dbl := masCoord{
		c,
		{c[0] - 1, c[1] + 1},
		{c[0] - 2, c[1] + 2},
	}
	dbr := masCoord{
		c,
		{c[0] + 1, c[1] + 1},
		{c[0] + 2, c[1] + 2},
	}

	var n int

	if isMas(g, dtl, 0, 0) && (isMas(g, dtr, -2, 0) || isMas(g, dbl, 0, -2)) {
		n++
	} else if isMas(g, dtr, 0, 0) && (isMas(g, dtl, +2, 0) || isMas(g, dbr, 0, -2)) {
		n++
	} else if isMas(g, dbl, 0, 0) && (isMas(g, dbr, -2, 0) || isMas(g, dtl, 0, +2)) {
		n++
	} else if isMas(g, dbr, 0, 0) && (isMas(g, dbl, +2, 0) || isMas(g, dtr, 0, +2)) {
		n++
	}

	return n
}

func isMas(g grid, c masCoord, xDelta, yDelta int) bool {
	for i, coord := range c {
		coord[0] += xDelta
		coord[1] += yDelta

		if g[coord] != mas[i] {
			return false
		}
	}

	return true
}
