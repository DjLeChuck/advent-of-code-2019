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
	//p2v, p2d := partTwo(g)
	//fmt.Printf("Part one: %d - elapsed: %s\n", p2v, p2d)
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

				if a.x >= 0 && a.x <= maxX && a.y >= 0 && a.y <= maxY {
					l[a] = nil
				}
				if b.x >= 0 && b.x <= maxX && b.y >= 0 && b.y <= maxY {
					l[b] = nil
				}
			}
		}
	}

	return len(l), time.Since(t).String()
}

func partTwo(g grid, maxY, maxX int) (int, string) {
	t := time.Now()

	return 0, time.Since(t).String()
}
