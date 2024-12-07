package main

import (
	"fmt"
	"math"
	"regexp"
	"slices"
	"strings"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

type rule struct {
	left, right int
}
type rules []rule

type update []int
type updates []update

func main() {
	in := utils.ParseInput("inputs/2024/05.txt")
	r, u := processInput(in)

	p1v, p1d := partOne(r, u)
	fmt.Printf("Part one: %d - elapsed: %s\n", p1v, p1d)
}

func processInput(in utils.Input) (rules, updates) {
	var r rules
	var u updates

	rre := regexp.MustCompile(`^(\d+)\|(\d+)$`)

	for _, line := range in {
		if line == "" {
			continue
		}

		if rre.MatchString(line) {
			m := rre.FindStringSubmatch(line)
			r = append(r, rule{left: utils.CastInt(m[1]), right: utils.CastInt(m[2])})

			continue
		}

		parts := strings.FieldsFunc(line, func(r rune) bool {
			return r == ','
		})
		up := make(update, len(parts))
		for i, part := range parts {
			up[i] = utils.CastInt(part)
		}
		u = append(u, up)

	}

	return r, u
}

func partOne(r rules, u updates) (int, string) {
	t := time.Now()
	n := 0

	for _, up := range u {
		ni := len(up)
		gi := 0

		for i, v := range up {
			if updateValueCorrect(i, v, up, r) {
				gi++
			}
		}

		if ni == gi {
			n += middlePageNumber(up)
		}
	}

	return n, time.Since(t).String()
}

func partTwo(r rules, u updates) (int, string) {
	t := time.Now()
	n := 0

	return n, time.Since(t).String()
}

func grabUpdateRules(v int, u update, r rules) rules {
	rr := rules{}

	for _, ru := range r {
		if (v == ru.left && slices.Contains(u, ru.right)) || (v == ru.right && slices.Contains(u, ru.left)) {
			rr = append(rr, ru)
		}
	}

	return rr
}

func updateValueCorrect(i, v int, u update, r rules) bool {
	ru := grabUpdateRules(v, u, r)
	pb := u[0:i]
	pa := u[i+1:]

	for _, rv := range ru {
		if v == rv.left && slices.Contains(pb, rv.right) {
			return false
		}
		if v == rv.right && slices.Contains(pa, rv.left) {
			return false
		}
	}

	return true
}

func middlePageNumber(u update) int {
	return u[int(math.Floor(float64(len(u)/2)))]
}
