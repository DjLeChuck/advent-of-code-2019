package main

import (
	"fmt"
	"strconv"
	"strings"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

type field []int64
type stoneCache map[int64]int

func main() {
	in := utils.ParseInput("inputs/2024/11.txt")
	f := processInput(in)

	p1v, p1d := blink(f, 25)
	fmt.Printf("Part one: %d - elapsed: %s\n", p1v, p1d)
	p2v, p2d := blink(f, 75)
	fmt.Printf("Part two: %d - elapsed: %s\n", p2v, p2d)
}

func processInput(in utils.Input) field {
	var f field

	for _, line := range in {
		parts := strings.Fields(line)

		for _, part := range parts {
			f = append(f, utils.CastInt64(part))
		}
	}

	return f
}

func blink(f field, ni int) (int, string) {
	t := time.Now()

	c := make(stoneCache)
	for _, val := range f {
		c[val]++
	}

	for i := 0; i < ni; i++ {
		c = score(c)
	}

	n := 0
	for _, count := range c {
		n += count
	}

	return n, time.Since(t).String()
}

func score(c stoneCache) stoneCache {
	nc := make(stoneCache)

	for s, count := range c {
		if s == 0 {
			nc[1] += count

			continue
		}

		if len(strconv.FormatInt(s, 10))%2 == 0 {
			left, right := splitInt(s)
			nc[left] += count
			nc[right] += count

			continue
		}

		nc[s*2024] += count
	}
	return nc
}

func splitInt(i int64) (i1, i2 int64) {
	v := strconv.FormatInt(i, 10)
	m := len(v) / 2

	return utils.CastInt64(v[:m]), utils.CastInt64(v[m:])
}
