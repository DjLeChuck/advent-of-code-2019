package main

import (
	"fmt"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

type coord struct {
	x, y int
}
type gridPoints = map[coord]int
type grid struct {
	points     gridPoints
	trailheads []coord
}

func main() {
	in := utils.ParseInput("inputs/2024/10.txt")
	g := processInput(in)

	p1v, p1d := partOne(g)
	fmt.Printf("Part one: %d - elapsed: %s\n", p1v, p1d)
	p2v, p2d := partTwo(g)
	fmt.Printf("Part two: %d - elapsed: %s\n", p2v, p2d)
}

func processInput(in utils.Input) grid {
	g := newGrid()

	for y, line := range in {
		for x, v := range line {
			pv := utils.CastInt(string(v))
			c := coord{x, y}
			g.points[c] = pv

			if pv == 0 {
				g.trailheads = append(g.trailheads, c)
			}
		}
	}

	return g
}

func partOne(g grid) (int, string) {
	t := time.Now()
	n := 0

	for _, c := range g.trailheads {
		visited := make(map[coord]bool)
		top := make(map[coord]bool)
		findTops(c, &g, visited, top)
		n += len(top)
	}

	return n, time.Since(t).String()
}

func partTwo(g grid) (int, string) {
	t := time.Now()
	n := 0

	for _, c := range g.trailheads {
		n += countPaths(c, &g)
	}

	return n, time.Since(t).String()
}

func newGrid() grid {
	return grid{
		points: make(gridPoints),
	}
}

func findTops(c coord, g *grid, visited, top map[coord]bool) {
	if visited[c] {
		return
	}

	visited[c] = true

	for _, nc := range c.availCoords(g) {
		if nc.isTop(g) {
			top[nc] = true
		} else {
			findTops(nc, g, visited, top)
		}
	}
}

func countPaths(c coord, g *grid) int {
	n := 0

	for _, nc := range c.availCoords(g) {
		if nc.isTop(g) {
			n++
		} else {
			n += countPaths(nc, g)
		}
	}
	return n
}

func (c coord) availCoords(g *grid) []coord {
	var gp []coord
	tc := coord{c.x, c.y - 1}
	rc := coord{c.x + 1, c.y}
	bc := coord{c.x, c.y + 1}
	lc := coord{c.x - 1, c.y}

	if _, ok := g.points[tc]; ok {
		if tc.isReachable(g, c) {
			gp = append(gp, tc)
		}
	}
	if _, ok := g.points[rc]; ok {
		if rc.isReachable(g, c) {
			gp = append(gp, rc)
		}
	}
	if _, ok := g.points[bc]; ok {
		if bc.isReachable(g, c) {
			gp = append(gp, bc)
		}
	}
	if _, ok := g.points[lc]; ok {
		if lc.isReachable(g, c) {
			gp = append(gp, lc)
		}
	}

	return gp
}

func (c coord) isReachable(g *grid, b coord) bool {
	return g.points[b] == g.points[c]-1
}

func (c coord) isTop(g *grid) bool {
	return g.points[c] == 9
}
