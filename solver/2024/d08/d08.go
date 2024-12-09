package main

import (
	"fmt"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

type coord struct {
	x, y int
}
type grid map[string][]coord

func main() {
	in := utils.ParseInput("inputs/2024/08.txt")
	g, maxY, maxX := processInput(in)

	p1v, p1d := partOne(g, maxY, maxX)
	fmt.Printf("Part one: %d - elapsed: %s\n", p1v, p1d)
	p2v, p2d := partTwo(g, maxY, maxX)
	fmt.Printf("Part one: %d - elapsed: %s\n", p2v, p2d)
}

func processInput(in utils.Input) (grid, int, int) {
	g := grid{}

	for y, line := range in {
		for x, c := range line {
			if string(c) != "." {
				g[string(c)] = append(g[string(c)], coord{x, y})
			}
		}
	}

	return g, len(in) - 1, len(in[0]) - 1
}

func partOne(g grid, maxY, maxX int) (int, string) {
	t := time.Now()
	l := make(map[coord]any)

	for _, coords := range g {
		for _, c := range coords {
			for _, c2 := range coords {
				if c == c2 {
					continue
				}

				xDiff := c.x - c2.x
				yDiff := c.y - c2.y

				a := coord{c.x + xDiff, c.y + yDiff}
				b := coord{c2.x - xDiff, c2.y - yDiff}

				if inBounds(a, maxY, maxX) {
					l[a] = nil
				}
				if inBounds(b, maxY, maxX) {
					l[b] = nil
				}
			}
		}
	}

	return len(l), time.Since(t).String()
}

func partTwo(g grid, maxY, maxX int) (int, string) {
	t := time.Now()
	l := make(map[coord]any)

	for _, coords := range g {
		for _, c := range coords {
			for _, c2 := range coords {
				if c == c2 {
					continue
				}

				anc := getAntinodesCoords(c, c2, maxY, maxX)

				for can := range anc {
					l[can] = nil
				}
			}
		}
	}

	return len(l), time.Since(t).String()
}

func inBounds(c coord, maxY, maxX int) bool {
	return c.x >= 0 && c.x <= maxX && c.y >= 0 && c.y <= maxY
}

func getAntinodesCoords(c1, c2 coord, maxY, maxX int) map[coord]any {
	anc := make(map[coord]any)

	anc[c1] = nil
	anc[c2] = nil

	xDiff := c1.x - c2.x
	yDiff := c1.y - c2.y
	a := coord{c1.x + xDiff, c1.y + yDiff}
	b := coord{c2.x - xDiff, c2.y - yDiff}

	for inBounds(a, maxY, maxX) {
		anc[a] = nil
		a.x += xDiff
		a.y += yDiff
	}

	for inBounds(b, maxY, maxX) {
		anc[b] = nil
		b.x -= xDiff
		b.y -= yDiff
	}

	return anc
}
