using System;
using System.Collections.Generic;

public class Puzzle3 : Puzzle {
    const char Up = '^';
    const char Down = 'v';
    const char Left = '<';
    const char Right = '>';

    protected override byte _day { get { return 3; } }

    public override Puzzle Solve(string input) {
        var santaSolo = DeliveryManPool.Create();
        var santa = DeliveryManPool.Create();
        var robo = DeliveryManPool.Create();

        for (int i = 0, len = input.Length; i < len; i++) {
            var c = input[i];

            if (i % 2 == 0) {
                santa.Move(c);
            } else {
                robo.Move(c);
            }

            santaSolo.Move(c);
        }

        _res1 = santaSolo.positions.Count;
        santa.positions.UnionWith(robo.positions);
        _res2 = santa.positions.Count;

        DeliveryManPool.Remove(santaSolo);
        DeliveryManPool.Remove(santa);
        DeliveryManPool.Remove(robo);

        return this;
    }

    class DeliveryMan {
        public readonly HashSet<string> positions = new HashSet<string>();

        int[] _location = new int[2];

        public DeliveryMan() {
            Init();
        }

        public void Init() {
            Array.Clear(_location, 0, _location.Length);
            _location[0] = 0;
            _location[1] = 0;

            positions.Clear();
            addLocation();
        }

        public void Move(char arrow) {
            if (arrow == Up) {
                _location[1]++;
            } else if (arrow == Down) {
                _location[1]--;
            } else if (arrow == Left) {
                _location[0]--;
            } else if (arrow == Right) {
                _location[0]++;
            }

            addLocation();
        }

        void addLocation() {
            positions.Add(string.Format("{0},{1}", _location[0], _location[1]));
        }
    }

    static class DeliveryManPool {
        readonly static HashSet<DeliveryMan> _deliverymen = new HashSet<DeliveryMan>();
        readonly static Stack<DeliveryMan> _reusables = new Stack<DeliveryMan>();

        public static DeliveryMan Create() {
            var deliveryman = _reusables.Count > 0 ? _reusables.Pop() : new DeliveryMan();
            _deliverymen.Add(deliveryman);

            return deliveryman;
        }

        public static void Remove(DeliveryMan deliveryman) {
            _deliverymen.Remove(deliveryman);
            deliveryman.Init();
            _reusables.Push(deliveryman);
        }
    }
}
