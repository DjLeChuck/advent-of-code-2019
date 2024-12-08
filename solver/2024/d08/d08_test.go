package main

import (
	"reflect"
	"testing"

	"github.com/djlechuck/advent-of-code/utils"
)

var (
	expectedMaxY = 11
	expectedMaxX = 11
	parsedInput  = grid{
		"0": {
			coord{8, 1},
			coord{5, 2},
			coord{7, 3},
			coord{4, 4},
		},
		"A": {
			coord{6, 5},
			coord{8, 8},
			coord{9, 9},
		},
	}
)

func TestProcessInput(t *testing.T) {
	in := utils.ParseInput("../../../inputs/2024/08_example.txt")
	g, maxY, maxX := processInput(in)

	if !reflect.DeepEqual(g, parsedInput) {
		t.Errorf("processInput() - g: got %v, want %v", g, parsedInput)
	}
	if maxY != expectedMaxY {
		t.Errorf("processInput() - maxY: got %v, want %v", maxY, expectedMaxY)
	}
	if maxX != expectedMaxX {
		t.Errorf("processInput() - maxX: got %v, want %v", maxY, expectedMaxX)
	}
}

func TestPartOne(t *testing.T) {
	expected := 14

	result, _ := partOne(parsedInput, expectedMaxY, expectedMaxX)
	if result != expected {
		t.Errorf("partOne() = %d, want %d", result, expected)
	}
}

func TestPartTwo(t *testing.T) {
	expected := 34

	result, _ := partTwo(parsedInput, expectedMaxY, expectedMaxX)
	if result != expected {
		t.Errorf("partTwo() = %d, want %d", result, expected)
	}
}
