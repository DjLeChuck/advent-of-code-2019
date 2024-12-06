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
type pathInfo struct {
	passed   bool
	position string
}

func main() {
	in := utils.ParseInput("inputs/2024/06.txt")
	gr, gu := processInput(in)

	p1v, p1d := partOne(gr, gu)
	fmt.Printf("Part one: %d - elapsed: %s\n", p1v, p1d)
	p2v, p2d := partTwo(gr, gu)
	fmt.Printf("Part two: %d - elapsed: %s\n", p2v, p2d)
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
	p, _ := getPath(gr, gu)

	return len(p), time.Since(t).String()
}

func partTwo(gr grid, gu guard) (int, string) {
	t := time.Now()
	n := 0
	p, _ := getPath(gr, gu)
	fgp := gu.coord

	for c := range p {
		if fgp == c {
			continue
		}

		ngu := gu
		ngr := newGrid(gr, c)
		_, looping := getPath(ngr, ngu)
		if looping {
			n++
		}
	}

	return n, time.Since(t).String()
}

func newGrid(gr grid, coord coord) grid {
	ngr := grid{}

	for c, s := range gr {
		ngr[c] = s
	}

	ngr[coord] = "#"

	return ngr
}

func getPath(gr grid, gu guard) (map[coord]pathInfo, bool) {
	path := make(map[coord]pathInfo)

	for gr.inBounds(gu.coord) {
		ngc := nextGuardCoord(gu)

		if isAccessible(gr, ngc) {
			pi := path[gu.coord]
			if !pi.passed {
				path[gu.coord] = pathInfo{true, gu.pos}
			} else if pi.position == gu.pos {
				return nil, true
			}

			gu.move(ngc)
		} else {
			gu.rotate()
		}
	}

	return path, false
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
