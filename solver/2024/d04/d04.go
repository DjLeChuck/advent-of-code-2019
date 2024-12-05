package main

import (
	"fmt"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

type Coord [2]int
type XmasCoord [4]Coord
type MasCoord [3]Coord
type Grid map[Coord]string

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

func processInput(in []string) Grid {
	m := make(Grid)
	for x, r := range in {
		for y, c := range r {
			m[Coord{x, y}] = string(c)
		}
	}
	return m
}

func partOne(g Grid) (int, string) {
	t := time.Now()
	var n int

	for coord, c := range g {
		if "X" == c {
			n += countXmas(g, coord)
		}
	}

	return n, time.Since(t).String()
}

func partTwo(g Grid) (int, string) {
	t := time.Now()
	var n int

	for coord, c := range g {
		if "M" == c {
			n += countXMas(g, coord)
		}
	}

	return n, time.Since(t).String()
}

func countXmas(g Grid, c Coord) int {
	rtl := XmasCoord{
		c,
		{c[0] - 1, c[1]},
		{c[0] - 2, c[1]},
		{c[0] - 3, c[1]},
	}
	ltr := XmasCoord{
		c,
		{c[0], c[1] + 1},
		{c[0], c[1] + 2},
		{c[0], c[1] + 3},
	}
	utb := XmasCoord{
		c,
		{c[0] + 1, c[1]},
		{c[0] + 2, c[1]},
		{c[0] + 3, c[1]},
	}
	btu := XmasCoord{
		c,
		{c[0], c[1] - 1},
		{c[0], c[1] - 2},
		{c[0], c[1] - 3},
	}
	dtl := XmasCoord{
		c,
		{c[0] - 1, c[1] - 1},
		{c[0] - 2, c[1] - 2},
		{c[0] - 3, c[1] - 3},
	}
	dtr := XmasCoord{
		c,
		{c[0] + 1, c[1] - 1},
		{c[0] + 2, c[1] - 2},
		{c[0] + 3, c[1] - 3},
	}
	dbl := XmasCoord{
		c,
		{c[0] - 1, c[1] + 1},
		{c[0] - 2, c[1] + 2},
		{c[0] - 3, c[1] + 3},
	}
	dbr := XmasCoord{
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

func isXmas(g Grid, c XmasCoord) bool {
	for i, coord := range c {
		if g[coord] != xmas[i] {
			return false
		}
	}

	return true
}

func countXMas(g Grid, c Coord) int {
	dtl := MasCoord{
		c,
		{c[0] - 1, c[1] - 1},
		{c[0] - 2, c[1] - 2},
	}
	dtr := MasCoord{
		c,
		{c[0] + 1, c[1] - 1},
		{c[0] + 2, c[1] - 2},
	}
	dbl := MasCoord{
		c,
		{c[0] - 1, c[1] + 1},
		{c[0] - 2, c[1] + 2},
	}
	dbr := MasCoord{
		c,
		{c[0] + 1, c[1] + 1},
		{c[0] + 2, c[1] + 2},
	}

	var n int

	if isMas(g, dtl, 0, 0) && (isMas(g, dtr, -2, 0) || isMas(g, dbl, 0, -2)) {
		fmt.Println("dtl", c)
		n++
	} else if isMas(g, dtr, 0, 0) && (isMas(g, dtl, +2, 0) || isMas(g, dbr, 0, -2)) {
		fmt.Println("dtr", c)
		n++
	} else if isMas(g, dbl, 0, 0) && (isMas(g, dbr, -2, 0) || isMas(g, dtl, 0, +2)) {
		fmt.Println("dbl", c)
		n++
	} else if isMas(g, dbr, 0, 0) && (isMas(g, dbl, +2, 0) || isMas(g, dtr, 0, +2)) {
		fmt.Println("dbr", c)
		n++
	}

	return n
}

func isMas(g Grid, c MasCoord, xDelta, yDelta int) bool {
	for i, coord := range c {
		coord[0] += xDelta
		coord[1] += yDelta

		if g[coord] != mas[i] {
			return false
		}
	}

	return true
}
