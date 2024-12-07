package main

import (
	"fmt"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

type coord [2]int
type xmasCoord [4]coord
type grid map[coord]string

var (
	xmas = [4]string{"X", "M", "A", "S"}
)

func main() {
	in := utils.ParseInput("inputs/2024/04.txt")
	g := processInput(in)

	p1v, p1d := partOne(g)
	fmt.Printf("Part one: %d - elapsed: %s\n", p1v, p1d)
	p2v, p2d := partTwo(g)
	fmt.Printf("Part two: %d - elapsed: %s\n", p2v, p2d)
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
		if "A" == c {
			n += countMas(g, coord)
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

func countMas(g grid, c coord) int {
	ul := coord{c[0] - 1, c[1] - 1}
	ur := coord{c[0] + 1, c[1] - 1}
	bl := coord{c[0] - 1, c[1] + 1}
	br := coord{c[0] + 1, c[1] + 1}

	var n int

	if (("M" == g[ul] && "S" == g[br]) || ("S" == g[ul] && "M" == g[br])) &&
		(("M" == g[ur] && "S" == g[bl]) || ("S" == g[ur] && "M" == g[bl])) {
		n++
	}

	return n
}
