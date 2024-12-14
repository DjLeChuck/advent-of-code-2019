package main

import (
	"fmt"
	"regexp"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

type grid struct {
	maxX, maxY int
}
type position struct {
	x, y int
}
type velocity struct {
	x, y int
}
type robot struct {
	pos position
	vel velocity
}

func main() {
	in := utils.ParseInput("inputs/2024/14.txt")
	r := processInput(in)
	g := grid{maxX: 101, maxY: 103}

	p1v, p1d := partOne(r, g)
	fmt.Printf("Part one: %d - elapsed: %s\n", p1v, p1d)
}

func processInput(in utils.Input) []*robot {
	var r []*robot
	regex := regexp.MustCompile(`p=(-?\d+),(-?\d+) v=(-?\d+),(-?\d+)`)

	for _, line := range in {
		matches := regex.FindStringSubmatch(line)
		r = append(r, &robot{
			pos: position{utils.CastInt(matches[1]), utils.CastInt(matches[2])},
			vel: velocity{utils.CastInt(matches[3]), utils.CastInt(matches[4])},
		})
	}

	return r
}

func partOne(r []*robot, g grid) (int, string) {
	t := time.Now()

	for i := 0; i < 100; i++ {
		for _, ro := range r {
			ro.move(g)
		}
	}

	return g.safetyFactor(r), time.Since(t).String()
}

func partTwo() (int, string) {
	t := time.Now()

	return 0, time.Since(t).String()
}

func (r *robot) move(g grid) {
	r.pos.x += r.vel.x
	r.pos.y += r.vel.y

	if r.pos.x < 0 {
		r.pos.x += g.maxX
	} else if r.pos.x >= g.maxX {
		r.pos.x -= g.maxX
	}

	if r.pos.y < 0 {
		r.pos.y += g.maxY
	} else if r.pos.y >= g.maxY {
		r.pos.y -= g.maxY
	}
}

func (r *robot) inGridQuadrant(g *grid) (bool, int) {
	midX := g.midX()
	midY := g.midY()

	if r.pos.x < midX && r.pos.y < midY {
		return true, 0
	}

	if r.pos.x > midX && r.pos.y > midY {
		return true, 1
	}

	if r.pos.x < midX && r.pos.y > midY {
		return true, 2
	}

	if r.pos.x > midX && r.pos.y < midY {
		return true, 3
	}

	return false, -1
}

func (g *grid) midX() int {
	return g.maxX / 2
}

func (g *grid) midY() int {
	return g.maxY / 2
}

func (g *grid) safetyFactor(r []*robot) int {
	q := []int{0, 0, 0, 0}

	for _, ro := range r {
		ok, quadrant := ro.inGridQuadrant(g)
		if ok {
			q[quadrant]++
		}
	}

	n := q[0]
	for _, i := range q[1:] {
		n *= i
	}

	return n
}
