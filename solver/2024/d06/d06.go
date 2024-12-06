package main

import (
	"fmt"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

type coord struct {
	x, y int
}
type grid map[coord]string
type guard struct {
	coord
	pos string
}

func main() {
	in := utils.ParseInput("inputs/2024/06.txt")
	gr, gu := processInput(in)

	p1v, p1d := partOne(gr, gu)
	fmt.Printf("Part one: %d - elapsed: %s\n", p1v, p1d)
}

func processInput(in utils.Input) (grid, guard) {
	gr := grid{}
	gu := guard{}

	for y, line := range in {
		for x, c := range line {
			if string(c) == "^" {
				gu = guard{coord{x, y}, "^"}
				gr[coord{x, y}] = "."
			} else {
				gr[coord{x, y}] = string(c)
			}
		}
	}

	return gr, gu
}

func partOne(gr grid, gu guard) (int, string) {
	t := time.Now()
	path := make(map[coord]bool)

	for gr.inBounds(gu.coord) {
		ngc := nextGuardCoord(gu)

		if isAccessible(gr, ngc) {
			ok := path[gu.coord]
			if !ok {
				path[gu.coord] = true
			}

			gu.move(ngc)
		} else {
			gu.rotate()
		}
	}

	return len(path), time.Since(t).String()
}

func partTwo() (int, string) {
	t := time.Now()
	n := 0

	return n, time.Since(t).String()
}

func isAccessible(gr grid, coord coord) bool {
	return "#" != gr[coord]
}

func (g *guard) move(coord coord) {
	g.coord = coord
}

func (g *guard) rotate() {
	g.pos = nextGuardPos(*g)
}

func (g *grid) inBounds(coord coord) bool {
	_, ok := (*g)[coord]
	return ok
}

func nextGuardCoord(g guard) coord {
	switch g.pos {
	case "^":
		return coord{g.x, g.y - 1}
	case ">":
		return coord{g.x + 1, g.y}
	case "v":
		return coord{g.x, g.y + 1}
	case "<":
		return coord{g.x - 1, g.y}
	default:
		panic("Cannot determine next guard coord")
	}
}

func nextGuardPos(g guard) string {
	switch g.pos {
	case "^":
		return ">"
	case ">":
		return "v"
	case "v":
		return "<"
	case "<":
		return "^"
	default:
		panic("Invalid guard position")
	}
}
